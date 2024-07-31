<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Plugin\Magexperts\GoogleTagManager\Api\DataLayer;

use Magexperts\GoogleTagManager\Api\DataLayer\PurchaseInterface as Subject;
use Magexperts\GoogleTagManager\Model\TransactionFactory;
use Magento\Sales\Model\Order;
use Magexperts\GoogleTagManager\Api\Transaction\LogInterface as TransactionLog;

class PurchaseInterface
{
    /**
     * @var TransactionLog
     */
    protected $transactionLog;

    /**
     * @param TransactionLog $transactionLog
     */
    public function __construct(
        TransactionLog $transactionLog
    ) {
        $this->transactionLog = $transactionLog;
    }

    /**
     * Prevent double purchase tracking by the same requester
     * @param Subject $subject
     * @param $proceed
     * @param Order $order
     * @param string $requester
     * @return array
     */
    public function aroundGet(Subject $subject, $proceed, Order $order, string $requester = ''): array
    {
        if ($this->transactionLog->isTransactionUnique($order, $requester)) {
            $this->transactionLog->logTransaction($order, $requester);
            return $proceed($order, $requester);
        } else {
            return [];
        }
    }
}
