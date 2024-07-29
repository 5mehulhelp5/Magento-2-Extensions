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

class AddToCart implements ObserverInterface
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
     * @var \Magento\Catalog\Model\ProductRepository
     */
    protected $productRepository;

    /**
     * AddToCart constructor.
     * @param \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession
     * @param \Magexperts\FacebookPixel\Helper\Data $helper
     * @param \Magento\Catalog\Model\ProductRepository $productRepository
     */
    public function __construct(
        \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession,
        \Magexperts\FacebookPixel\Helper\Data $helper,
        \Magento\Catalog\Model\ProductRepository $productRepository
    ) {
        $this->fbPixelSession = $fbPixelSession;
        $this->helper        = $helper;
        $this->productRepository = $productRepository;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $items = $observer->getItems();
        $typeConfi = \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE;
        if (!$this->helper->isAddToCart() || !$items) {
            return true;
        }
        $product = [
            'content_ids' => [],
            'value' => 0,
            'currency' => ""
        ];

        /** @var \Magento\Sales\Model\Order\Item $item */
        foreach ($items as $item) {
            if ($item->getProduct()->getTypeId() == $typeConfi) {
                continue;
            }
            if ($item->getParentItem()) {
                if ($item->getParentItem()->getProductType() == $typeConfi) {
                    $product['contents'][] = [
                        'id' => $item->getSku(),
                        'name' => $item->getName(),
                        'quantity' => $item->getParentItem()->getQtyToAdd()
                    ];
                    $product['value'] += $item->getProduct()->getFinalPrice() * $item->getParentItem()->getQtyToAdd();
                } else {
                    $product['contents'][] = [
                        'id' => $item->getSku(),
                        'name' => $item->getName(),
                        'quantity' => $item->getData('qty')
                    ];
                }
            } else {
                $product['contents'][] = [
                    'id' => $this->checkBundleSku($item),
                    'name' => $item->getName(),
                    'quantity' => $item->getQtyToAdd()
                ];
                $product['value'] += $item->getProduct()->getFinalPrice() * $item->getQtyToAdd();
            }
            $product['content_ids'][] = $this->checkBundleSku($item);
        }

        $data = [
            'content_type' => 'product',
            'content_ids' => $product['content_ids'],
            'contents' => $product['contents'],
            'currency' => $this->helper->getCurrencyCode(),
            'value' => $product['value']
        ];

        $this->fbPixelSession->create()->setAddToCart($data);

        return true;
    }

    /**
     * @param mixed $item
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function checkBundleSku($item)
    {
        $typeBundle = \Magento\Bundle\Model\Product\Type::TYPE_CODE;
        if ($item->getProductType() == $typeBundle) {
            $skuBundleProduct= $this->productRepository->getById($item->getProductId())->getSku();
            return $skuBundleProduct;
        }
        return $item->getSku();
    }
}
