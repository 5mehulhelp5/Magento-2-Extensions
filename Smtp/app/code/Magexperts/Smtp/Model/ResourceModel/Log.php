<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\VersionControl\AbstractDb;

class Log extends AbstractDb
{
    /**
     *  Smtp Log Store Table Name
     */
    const AITOC_SMTP_LOG_TABLE_NAME = 'magexperts_smtp_log';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(
            self::AITOC_SMTP_LOG_TABLE_NAME,
            \Magexperts\Smtp\Model\Log::LOG_ID_TYPE_FIELD
        );
    }
}
