<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Api\Data;

interface RulesInterface
{
    const ENTITY_ID = 'entity_id';
    const TITLE = 'title';
    const SCOPE = 'scope';
    const ORDER_STATUSES = 'order_statuses';
    const ACTION = 'action';
    const TIME = 'time';
    const IS_ACTIVE = 'is_active';

    /**
     * Returns entity_id field
     *
     * @return int
     */
    public function getEntityId();

    /**
     * Set entity_id
     *
     * @param int $entity_id
     * @return $this
     */
    public function setEntityId($entity_id);

    /**
     * Returns title field
     *
     * @return string
     */
    public function getTitle();

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * Returns scope field
     *
     * @return int
     */
    public function getScope();

    /**
     * Set scope
     *
     * @param int $scope
     * @return $this
     */
    public function setScope($scope);

    /**
     * Returns order_statuses field
     *
     * @return string
     */
    public function getOrderStatues();

    /**
     * Set statuses
     *
     * @param string $statuses
     * @return $this
     */
    public function setOrderStatues($statuses);

    /**
     * Returns action field
     *
     * @return int
     */
    public function getAction();

    /**
     * Set action
     *
     * @param int $action
     * @return $this
     */
    public function setAction($action);

    /**
     * Returns time field
     *
     * @return int
     */
    public function getTime();

    /**
     * Set time
     *
     * @param int $time
     * @return $this
     */
    public function setTime($time);

    /**
     * Returns action field
     *
     * @return bool
     */
    public function getIsActive();

    /**
     * Set is_active
     *
     * @param bool $is_active
     * @return $this
     */
    public function setIsActive($is_active);
}
