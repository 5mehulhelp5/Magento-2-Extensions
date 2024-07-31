<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Api\DataLayer\Cart;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote\Item;

interface ItemInterface
{
    /**
     * Get quote Item
     *
     * @param Item $quoteItem
     * @return array
     * @throws NoSuchEntityException
     */
    public function get(Item $quoteItem): array;
}
