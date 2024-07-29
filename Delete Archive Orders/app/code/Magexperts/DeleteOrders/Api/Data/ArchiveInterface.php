<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Api\Data;

interface ArchiveInterface
{
    const RECORD_ID = 'record_id';
    const ORDER_ID = 'order_id';
    const ARCHIVED_AT = 'archived_at';

    /**
     * Returns record_id field
     *
     * @return int
     */
    public function getRecordId();

    /**
     * Set record_id
     *
     * @param int $record_id
     * @return $this
     */
    public function setRecordId($record_id);

    /**
     * Returns orderId field
     *
     * @return int
     */
    public function getOrderId();

    /**
     * Set order_id
     *
     * @param int $order_id
     * @return $this
     */
    public function setOrderId($order_id);

    /**
     * Returns archived_at field
     *
     * @return string
     */
    public function getArchivedAt();

    /**
     * Set archived_at
     *
     * @param string $date
     * @return $this
     */
    public function setArchivedAt($date);
}
