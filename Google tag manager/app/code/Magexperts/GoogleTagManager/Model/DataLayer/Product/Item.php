<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Model\DataLayer\Product;

use Magexperts\GoogleTagManager\Api\DataLayer\Product\ItemInterface;
use Magexperts\GoogleTagManager\Model\AbstractDataLayer;
use Magento\Catalog\Model\Product;

class Item extends AbstractDataLayer implements ItemInterface
{
    /**
     * @inheritDoc
     */
    public function get(Product $product): array
    {
        $categoryNames = $this->getCategoryNames($product);
        return array_merge([
            'item_id' => $this->getProductAttributeValue($product, $this->config->getProductAttribute()),
            'item_name' => $product->getName(),
            'item_brand' => $this->getProductAttributeValue($product, $this->config->getBrandAttribute()),
            'price' => $this->getProductValue($product)
        ], $categoryNames);
    }
}
