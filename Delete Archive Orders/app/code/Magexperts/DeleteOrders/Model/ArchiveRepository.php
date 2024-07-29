<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model;

use Magexperts\DeleteOrders\Api\ArchiveRepositoryInterface;
use Magexperts\DeleteOrders\Api\Data;
use Magexperts\DeleteOrders\Model\ResourceModel\Archive;
use Magento\Framework\Config\Dom\ValidationException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class ArchiveRepository
 *
 * Order archive repository
 */
class ArchiveRepository implements ArchiveRepositoryInterface
{
    /**
     * @var Archive
     */
    protected $archiveModelResource;

    /**
     * @var ArchiveFactory
     */
    protected $archiveModelFactory;

    /**
     * ArchiveRepository constructor.
     *
     * @param Archive $archiveModelResource
     * @param ArchiveFactory $archiveModelFactory
     */
    public function __construct(
        Archive $archiveModelResource,
        ArchiveFactory $archiveModelFactory
    ) {
        $this->archiveModelResource = $archiveModelResource;
        $this->archiveModelFactory = $archiveModelFactory;
    }

    /**
     * Save
     *
     * @param Data\ArchiveInterface $archiveModel
     * @return Data\ArchiveInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\ArchiveInterface $archiveModel)
    {
        try {
            $this->archiveModelResource->save($archiveModel);
        } catch (ValidationException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Unable to save model %1', $archiveModel->getEntityId()));
        }

        return $archiveModel;
    }

    /**
     * Get by record id
     *
     * @param int $recordId
     * @return Data\ArchiveInterface|\Magexperts\DeleteOrders\Model\Archive
     * @throws NoSuchEntityException
     */
    public function get($recordId)
    {
        /** @var \Magexperts\DeleteOrders\Model\Archive $model */
        $archiveModel = $this->archiveModelFactory->create();
        $this->archiveModelResource->load($archiveModel, $recordId);

        if (!$archiveModel->getEntityId()) {
            throw new NoSuchEntityException(__('Entity with specified ID "%1" not found.', $recordId));
        }

        return $archiveModel;
    }

    /**
     * Get by order id
     *
     * @param int $orderId
     * @return \Magexperts\DeleteOrders\Model\Archive
     */
    public function getByOrderId($orderId)
    {
        /** @var \Magexperts\DeleteOrders\Model\Archive $model */
        $model = $this->archiveModelFactory->create();
        $this->archiveModelResource->load($model, $orderId, 'order_id');

        return $model;
    }

    /**
     * Delete
     *
     * @param Data\ArchiveInterface $archiveModel
     * @return bool
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     */
    public function delete(Data\ArchiveInterface $archiveModel)
    {
        try {
            $this->archiveModelResource->delete($archiveModel);
        } catch (ValidationException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Unable to remove entity with ID%', $archiveModel->getRecordId()));
        }

        return true;
    }

    /**
     * Delete by id
     *
     * @param int $recordId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function deleteById($recordId)
    {
        try {
            $model = $this->get($recordId);
            $this->delete($model);
        } catch (CouldNotDeleteException $e) {
            return false;
        }
        return true;
    }

    /**
     * Delete by order id
     *
     * @param int $orderId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     */
    public function deleteByOrderId($orderId)
    {
        try {
            $model = $this->getByOrderId($orderId);
            $this->delete($model);
        } catch (CouldNotDeleteException $e) {
            return false;
        }
        return true;
    }
}
