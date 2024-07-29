<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model\ResourceModel\Order;

use Magento\Sales\Model\ResourceModel\Order\Collection as OrderCollection;

/**
 * Class Collection
 *
 * Get order collection
 */
class Collection extends OrderCollection
{
    /**
     * Add archive table to collection
     *
     * @param string[] $fieldsToSelect
     * @param bool $isArchived
     * @return $this
     */
    public function joinArchiveTable($fieldsToSelect = ['order_id'], $isArchived = false)
    {
        $this->getSelect()->joinLeft(
            ['archive_table' => $this->getTable(\Magexperts\DeleteOrders\Model\ResourceModel\Archive::TABLE_NAME)],
            'main_table.entity_id = archive_table.order_id',
            $fieldsToSelect
        );
        $this->addFieldToFilter('archive_table.order_id', [$isArchived ? 'notnull' : 'null' => true]);
        return $this;
    }
}
