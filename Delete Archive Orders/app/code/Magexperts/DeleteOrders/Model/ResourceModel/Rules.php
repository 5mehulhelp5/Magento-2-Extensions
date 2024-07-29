<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Rules
 *
 * Rules resource
 */
class Rules extends AbstractDb
{
    const TABLE_NAME = 'magexperts_deleteorders_rules';
    const ID_FIELD_NAME = 'entity_id';

    /**
     *  Class constructor
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD_NAME);
    }
}
