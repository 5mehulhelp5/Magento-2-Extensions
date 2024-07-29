<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Model\ResourceModel\Log;

use Magexperts\Smtp\Model\Log;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var \Magexperts\ShippingRules\Model\Date
     */
    private $date;

    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory, \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magexperts\Core\Model\Helpers\Date $date,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        $this->date = $date;
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
    }

    /**
     * _construct
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(\Magexperts\Smtp\Model\Log::class,
            \Magexperts\Smtp\Model\ResourceModel\Log::class
        );
        $this->_setIdFieldName($this->getResource()->getIdFieldName());
    }

    /**
     * @param $logId
     * @return $this
     */
    public function addLogIdFilter($logId)
    {
        $this->addFieldToFilter(Log::LOG_ID_TYPE_FIELD,
            [
                'eq' => $logId
            ]
        );

        return $this;
    }
}
