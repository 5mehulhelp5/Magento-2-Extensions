<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Archive
 *
 * Order archive
 */
class Archive extends AbstractDb
{
    const TABLE_NAME = 'magexperts_deleteorders_order_archive';
    const ID_FIELD_NAME = 'record_id';

    /**
     *  Class constructor
     */
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::ID_FIELD_NAME);
    }
}
