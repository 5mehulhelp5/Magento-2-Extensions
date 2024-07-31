<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Api\Transaction;

interface LogInterface
{
    /**
     * @param mixed $order
     * @param string $requester
     * @return void
     */
    public function logTransaction($order, string $requester);

    /**
     * @param mixed $order
     * @param string $requester
     * @return bool
     */
    public function isTransactionUnique($order, string $requester): bool;
}
