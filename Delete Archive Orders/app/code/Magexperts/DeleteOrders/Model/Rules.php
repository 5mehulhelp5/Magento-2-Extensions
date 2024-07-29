<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model;

use Magexperts\DeleteOrders\Api\Data\RulesInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Rules
 *
 * Rules model
 */
class Rules extends AbstractModel implements RulesInterface
{
    /**
     * Class constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(\Magexperts\DeleteOrders\Model\ResourceModel\Rules::class);
        $this->setIdFieldName('entity_id');
    }

    /**
     * Get entity id
     *
     * @return int entityId
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * Set entity id
     *
     * @param int $entityId
     * @return $this
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * Get title
     *
     * @return string title
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Get scope
     *
     * @return int scope
     */
    public function getScope()
    {
        return $this->getData(self::SCOPE);
    }

    /**
     * Set scope
     *
     * @param int $scope
     * @return $this
     */
    public function setScope($scope)
    {
        return $this->setData(self::SCOPE, $scope);
    }

    /**
     * Get order statuses
     *
     * @return string statuses
     */
    public function getOrderStatues()
    {
        return $this->getData(self::ORDER_STATUSES);
    }

    /**
     * Set order statuses
     *
     * @param string $statuses
     * @return $this
     */
    public function setOrderStatues($statuses)
    {
        return $this->setData(self::ORDER_STATUSES, $statuses);
    }

    /**
     * Get action
     *
     * @return int action
     */
    public function getAction()
    {
        return $this->getData(self::ACTION);
    }

    /**
     * Set action
     *
     * @param int $action
     * @return $this
     */
    public function setAction($action)
    {
        return $this->setData(self::ACTION, $action);
    }

    /**
     * Get time
     *
     * @return int time
     */
    public function getTime()
    {
        return $this->getData(self::TIME);
    }

    /**
     * Set time
     *
     * @param int $time
     * @return $this
     */
    public function setTime($time)
    {
        return $this->setData(self::TIME, $time);
    }

    /**
     * Get is active
     *
     * @return bool is_active
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * Set is active
     *
     * @param bool $is_active
     * @return $this
     */
    public function setIsActive($is_active)
    {
        return $this->setData(self::IS_ACTIVE, $is_active);
    }
}
