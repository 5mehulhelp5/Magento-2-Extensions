<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Api;

use Magexperts\DeleteOrders\Api\Data\RulesInterface;

interface RulesRepositoryInterface
{
    /**
     * Save
     *
     * @param \Magexperts\DeleteOrders\Api\Data\RulesInterface $rulesModel
     * @return \Magexperts\DeleteOrders\Api\Data\RulesInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(RulesInterface $rulesModel);

    /**
     * Get by entity id
     *
     * @param int $entityId
     * @return \Magexperts\DeleteOrders\Api\Data\RulesInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($entityId);

    /**
     * Delete
     *
     * @param \Magexperts\DeleteOrders\Api\Data\RulesInterface $rulesModel
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(RulesInterface $rulesModel);

    /**
     * Delete by id
     *
     * @param int $entityId
     * @return bool
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($entityId);
}
