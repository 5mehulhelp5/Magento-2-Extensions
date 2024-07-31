<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Api\DataLayer;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Catalog\Model\Product;

interface ViewItemInterface
{
    /**
     * Get GTM datalayer
     *
     * @param Product $product
     * @return array
     * @throws NoSuchEntityException
     */
    public function get(Product $product): array;
}
