<?php
/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category  Magexperts
 * @package   Magexperts_FacebookPixel
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\FacebookPixel\Observer;

use Magento\Framework\Event\ObserverInterface;

class InitiateCheckout implements ObserverInterface
{

    /**
     * @var \Magexperts\FacebookPixel\Model\SessionFactory
     */
    protected $fbPixelSession;

    /**
     * @var \Magento\Checkout\Model\SessionFactory
     */
    protected $checkoutSession;

    /**
     * @var \Magexperts\FacebookPixel\Helper\Data
     */
    protected $fbPixelHelper;

    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $dataPrice;

    /**
     * InitiateCheckout constructor.
     * @param \Magento\Checkout\Model\SessionFactory $checkoutSession
     * @param \Magexperts\FacebookPixel\Helper\Data $helper
     * @param \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession
     * @param \Magento\Framework\Pricing\Helper\Data $dataPrice
     */
    public function __construct(
        \Magento\Checkout\Model\SessionFactory $checkoutSession,
        \Magexperts\FacebookPixel\Helper\Data $helper,
        \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession,
        \Magento\Framework\Pricing\Helper\Data $dataPrice
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->fbPixelHelper         = $helper;
        $this->fbPixelSession = $fbPixelSession;
        $this->dataPrice = $dataPrice;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return boolean
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->fbPixelHelper->isInitiateCheckout()) {
            return true;
        }
        $checkout = $this->checkoutSession->create();
        if (empty($checkout->getQuote()->getAllVisibleItems())) {
            return true;
        }

        $product = [
            'content_ids' => [],
            'contents' => [],
            'value' => "",
            'currency' => ""
        ];
        $items = $checkout->getQuote()->getAllVisibleItems();
        foreach ($items as $item) {
            $product['contents'][] = [
                'id' => $item->getSku(),
                'name' => $item->getName(),
                'quantity' => $item->getQty(),
                'item_price' => $this->dataPrice->currency($item->getPrice(), false, false)
            ];
            $product['content_ids'][] = $item->getSku();
        }
        $data = [
            'content_ids' => $product['content_ids'],
            'contents' => $product['contents'],
            'content_type' => 'product',
            'value' => $checkout->getQuote()->getGrandTotal(),
            'currency' => $this->fbPixelHelper->getCurrencyCode(),
        ];
        $this->fbPixelSession->create()->setInitiateCheckout($data);

        return true;
    }
}
