<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model;

use Magexperts\DeleteOrders\Api\Data\ArchiveInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Archive
 *
 * Order archive
 */
class Archive extends AbstractModel implements ArchiveInterface
{
    /**
     * Class constructor
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(\Magexperts\DeleteOrders\Model\ResourceModel\Archive::class);
        $this->setIdFieldName('record_id');
    }

    /**
     * Get record id
     *
     * @return int recordId
     */
    public function getRecordId()
    {
        return $this->getData(self::RECORD_ID);
    }

    /**
     * Set record id
     *
     * @param int $recordId
     * @return $this
     */
    public function setRecordId($recordId)
    {
        return $this->setData(self::RECORD_ID, $recordId);
    }

    /**
     * Get order id
     *
     * @return int orderId
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * Set order id
     *
     * @param int $orderId
     * @return $this
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get archived at
     *
     * @return string archived_at
     */
    public function getArchivedAt()
    {
        return $this->getData(self::ARCHIVED_AT);
    }

    /**
     * Set archived at
     *
     * @param string $date
     * @return $this
     */
    public function setArchivedAt($date)
    {
        return $this->setData(self::ARCHIVED_AT, $date);
    }
}
