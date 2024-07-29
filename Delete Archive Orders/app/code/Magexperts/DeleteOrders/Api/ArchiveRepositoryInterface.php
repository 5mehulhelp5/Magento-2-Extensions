<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Api;

use Magexperts\DeleteOrders\Api\Data\ArchiveInterface;

interface ArchiveRepositoryInterface
{
    /**
     * Save
     *
     * @param \Magexperts\DeleteOrders\Api\Data\ArchiveInterface $archiveModel
     * @return \Magexperts\DeleteOrders\Api\Data\ArchiveInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(ArchiveInterface $archiveModel);

    /**
     * Get by entity id
     *
     * @param int $entityId
     * @return \Magexperts\DeleteOrders\Api\Data\ArchiveInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($entityId);

    /**
     * Delete
     *
     * @param \Magexperts\DeleteOrders\Api\Data\ArchiveInterface $archiveModel
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(ArchiveInterface $archiveModel);

    /**
     * Delete by id
     *
     * @param int $entityId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($entityId);
}
