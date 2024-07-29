<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model\ResourceModel\Rules;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * Rules collection
 */
class Collection extends AbstractCollection
{
    /**
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
            \Magexperts\DeleteOrders\Model\Rules::class,
            \Magexperts\DeleteOrders\Model\ResourceModel\Rules::class
        );
    }
}
