<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model;

use Magexperts\DeleteOrders\Api\RulesRepositoryInterface;
use Magexperts\DeleteOrders\Api\Data;
use Magexperts\DeleteOrders\Model\ResourceModel\Rules;
use Magento\Framework\Config\Dom\ValidationException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class RulesRepository
 *
 * Repository for rules
 */
class RulesRepository implements RulesRepositoryInterface
{
    /**
     * @var Rules
     */
    protected $rulesModelResource;

    /**
     * @var RulesFactory
     */
    protected $rulesModelFactory;

    /**
     * RulesRepository constructor.
     *
     * @param Rules $rulesModelResource
     * @param RulesFactory $rulesModelFactory
     */
    public function __construct(
        Rules $rulesModelResource,
        RulesFactory $rulesModelFactory
    ) {
        $this->rulesModelResource = $rulesModelResource;
        $this->rulesModelFactory = $rulesModelFactory;
    }

    /**
     * Save
     *
     * @param Data\RulesInterface $rulesModel
     * @return Data\RulesInterface
     * @throws CouldNotSaveException
     */
    public function save(Data\RulesInterface $rulesModel)
    {
        try {
            $this->rulesModelResource->save($rulesModel);
        } catch (ValidationException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Unable to save model %1', $rulesModel->getEntityId()));
        }

        return $rulesModel;
    }

    /**
     * Get by entity id
     *
     * @param int $entityId
     * @return Data\RulesInterface
     * @throws NoSuchEntityException
     */
    public function get($entityId)
    {
        $rulesModel = $this->rulesModelFactory->create();
        $this->rulesModelResource->load($rulesModel, $entityId);

        if (!$rulesModel->getEntityId()) {
            throw new NoSuchEntityException(__('Entity with specified ID "%1" not found.', $entityId));
        }

        return $rulesModel;
    }

    /**
     * Delete
     *
     * @param Data\RulesInterface $rulesModel
     * @return bool
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     */
    public function delete(Data\RulesInterface $rulesModel)
    {
        try {
            $this->rulesModelResource->delete($rulesModel);
        } catch (ValidationException $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Unable to remove entity with ID%', $rulesModel->getEntityId()));
        }

        return true;
    }

    /**
     * Delete by id
     *
     * @param int $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function deleteById($entityId)
    {
        try {
            $model = $this->get($entityId);
            $this->delete($model);
        } catch (CouldNotDeleteException $e) {
            return false;
        }
        return true;
    }
}
