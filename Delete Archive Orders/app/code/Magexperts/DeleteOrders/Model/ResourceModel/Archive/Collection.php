<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model\ResourceModel\Archive;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * Get archive collection
 */
class Collection extends AbstractCollection
{
    /**
     * Main table primary key field name
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Magexperts\DeleteOrders\Model\Archive::class,
            \Magexperts\DeleteOrders\Model\ResourceModel\Archive::class
        );
    }
}
