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

class WishlistAddProduct implements ObserverInterface
{

    /**
     * @var \Magexperts\FacebookPixel\Model\SessionFactory
     */
    protected $fbPixelSession;

    /**
     * @var \Magexperts\FacebookPixel\Helper\Data
     */
    protected $helper;

    /**
     * WishlistAddProduct constructor.
     * @param \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession
     * @param \Magexperts\FacebookPixel\Helper\Data $helper
     */
    public function __construct(
        \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession,
        \Magexperts\FacebookPixel\Helper\Data $helper
    ) {
        $this->fbPixelSession = $fbPixelSession;
        $this->helper        = $helper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return boolean
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getItem()->getProduct();
        /** @var \Magento\Catalog\Model\Product $product */
        if (!$this->helper->isAddToWishList() || !$product) {
            return true;
        }
        
        $data = [
            'content_type' => 'product',
            'content_ids' => $product->getSku(),
            'content_name' => $product->getName(),
            'currency' => $this->helper->getCurrencyCode()
        ];

        $this->fbPixelSession->create()->setAddToWishlist($data);
        
        return true;
    }
}
