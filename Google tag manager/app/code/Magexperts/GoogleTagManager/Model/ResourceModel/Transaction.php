<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Transaction extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('magexperts_gtm_transaction', 'id');
    }
}
