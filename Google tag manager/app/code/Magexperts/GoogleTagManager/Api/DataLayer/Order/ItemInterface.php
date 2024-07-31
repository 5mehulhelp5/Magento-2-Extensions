<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Api\DataLayer\Order;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderItemInterface;

interface ItemInterface
{
    /**
     * Get order item
     *
     * @param OrderItemInterface $orderItem
     * @return array
     * @throws NoSuchEntityException
     */
    public function get(OrderItemInterface $orderItem): array;
}
