<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Model\DataLayer\Cart;

use Magexperts\GoogleTagManager\Api\DataLayer\Cart\ItemInterface;
use Magexperts\GoogleTagManager\Model\AbstractDataLayer;
use Magento\Quote\Model\Quote\Item as QuoteItem;

class Item extends AbstractDataLayer implements ItemInterface
{
    /**
     * @inheritDoc
     */
    public function get(QuoteItem $quoteItem): array
    {
        $product = $quoteItem->getProduct();
        $categoryNames = $this->getCategoryNames($product);
        return array_merge([
            'item_id' => ($this->config->getProductAttribute() == 'sku')
                ? $quoteItem->getSku()
                : $this->getProductAttributeValue($product, $this->config->getProductAttribute()),
            'item_name' => $quoteItem->getName(),
            'discount' => $this->formatPrice((float)$quoteItem->getDiscountAmount()),
            'coupon_code' => $quoteItem->getQuote()->getCouponCode() ?: '',
            'item_brand' => $this->getProductAttributeValue($product, $this->config->getBrandAttribute()),
            'price' => $this->getValue($quoteItem),
            'quantity' => $quoteItem->getQty() * 1
        ], $categoryNames);
    }

    /**
     * @param $quoteItem
     * @return float
     */
    protected function getValue(QuoteItem $quoteItem): float
    {
        if ($this->config->isPurchaseTaxEnabled()) {
            $value = (float)$quoteItem->getPriceInclTax();
        } else {
            $value = (float)$quoteItem->getPrice();
        }

        //fix for magento 2.3.2 - module-quote/Model/Quote/Item/Processor.php prepareItem does not set price to quote item
        if (!$value && ($quoteItemProduct = $quoteItem->getProduct())) {
            return $this->getProductValue($quoteItemProduct);
        } else {
            return $this->formatPrice($value);
        }
    }
}
