<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Model\DataLayer\Order;

use Magexperts\GoogleTagManager\Api\DataLayer\Order\ItemInterface;
use Magexperts\GoogleTagManager\Model\AbstractDataLayer;
use Magento\Sales\Api\Data\OrderItemInterface;

class Item extends AbstractDataLayer implements ItemInterface
{
    /**
     * @inheritDoc
     */
    public function get(OrderItemInterface $orderItem): array
    {
        $product = $orderItem->getProduct();
        $categoryNames = $this->getCategoryNames($product);
        return array_merge([
            'item_id' => ($this->config->getProductAttribute() == 'sku')
                ? $orderItem->getSku()
                : $this->getProductAttributeValue($product, $this->config->getProductAttribute()),
            'item_name' => $orderItem->getName(),
            'discount' => $this->formatPrice((float)$orderItem->getDiscountAmount()),
            'item_brand' => $this->getProductAttributeValue($product, $this->config->getBrandAttribute()),
            'price' => $this->getValue($orderItem),
            'quantity' => $orderItem->getQtyOrdered() * 1
        ], $categoryNames);
    }

    /**
     * @param $quoteItem
     * @return float
     */
    protected function getValue(OrderItemInterface $orderItem): float
    {
        if ($this->config->isPurchaseTaxEnabled()) {
            $value = (float)$orderItem->getPriceInclTax();
        } else {
            $value = (float)$orderItem->getPrice();
        }

        return $this->formatPrice($value);
    }
}
