<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Api\DataLayer\Product;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Catalog\Model\Product;

interface ItemInterface
{
    /**
     * Get product item
     *
     * @param Product $product
     * @return array
     * @throws NoSuchEntityException
     */
    public function get(Product $product): array;
}
