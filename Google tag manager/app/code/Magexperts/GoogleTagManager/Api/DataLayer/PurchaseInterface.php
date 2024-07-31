<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Api\DataLayer;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Model\Order;

interface PurchaseInterface
{
    /**
     * Get GTM datalayer
     *
     * @param Order $order
     * @param string $requester
     * @return array
     * @throws NoSuchEntityException
     */
    public function get(Order $order, string $requester = ''): array;
}
