<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Model;

use Magexperts\GoogleTagManager\Model\ResourceModel\Transaction as ResourceTransaction;
use Magexperts\GoogleTagManager\Model\TransactionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class TransactionRepository
{

    /**
     * @var ResourceTransaction
     */
    protected $resource;

    /**
     * @var TransactionFactory
     */
    protected $transactionFactory;

    /**
     * @param ResourceTransaction $resource
     * @param TransactionFactory $transactionFactory
     */
    public function __construct(
        ResourceTransaction $resource,
        TransactionFactory $transactionFactory
    ) {
        $this->resource = $resource;
        $this->transactionFactory = $transactionFactory;
    }

    /**
     * @param Transaction $transaction
     * @return Transaction
     * @throws CouldNotSaveException
     */
    public function save(Transaction $transaction)
    {
        try {
            $this->resource->save($transaction);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the transaction: %1',
                $exception->getMessage()
            ));
        }
        return $transaction;
    }

    /**
     * @param $transactionId
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function get($transactionId)
    {
        $transaction = $this->transactionFactory->create();
        $this->resource->load($transaction, $transactionId);
        if (!$transaction->getId()) {
            throw new NoSuchEntityException(__('Transaction with id "%1" does not exist.', $transactionId));
        }
        return $transaction;
    }
}
