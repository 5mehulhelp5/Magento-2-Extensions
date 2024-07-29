<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model\ResourceModel\Archive\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Magexperts\DeleteOrders\Model\ResourceModel\Archive\Collection as ArchiveCollection;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Registry;

/**
 * Class Collection
 *
 * Grid collection
 */
class Collection extends ArchiveCollection implements SearchResultInterface
{
    /**
     * Main table primary key field name
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @var AggregationInterface
     */
    public $aggregations;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * Collection constructor.
     *
     * @param Registry $registry
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param StoreManagerInterface $storeManager
     * @param MetadataPool $metadataPool
     * @param string $mainTable
     * @param string $eventPrefix
     * @param string $eventObject
     * @param string $resourceModel
     * @param string $model
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|string|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        Registry $registry,
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        StoreManagerInterface $storeManager,
        MetadataPool $metadataPool,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = Document::class,
        $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
        $this->registry = $registry;
    }

    /**
     * Get aggregations
     *
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * Set aggregations
     *
     * @param AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Set items list.
     *
     * @param \Magento\Framework\Api\ExtensibleDataInterface[] $items
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null)
    {
        return $this;
    }

    /**
     * Add sales order grid table to collection
     *
     * @return $collection
     */
    public function joinSalesOrdeGridTable()
    {
        $this->getSelect()->joinLeft(
            ['order_grid_table' => $this->getTable("sales_order_grid")],
            'main_table.order_id = order_grid_table.entity_id'
        );
        $this->addFieldToFilter('main_table.order_id', ['notnull' => true]);
        return $this;
    }

    /**
     * Get all order ids
     *
     * @return array
     */
    public function getAllIds()
    {
        if ($this->registry->registry('mass_action_flag')) {
            $idsSelect = clone $this->getSelect();
            $idsSelect->reset(\Magento\Framework\DB\Select::ORDER);
            $idsSelect->reset(\Magento\Framework\DB\Select::LIMIT_COUNT);
            $idsSelect->reset(\Magento\Framework\DB\Select::LIMIT_OFFSET);
            $idsSelect->reset(\Magento\Framework\DB\Select::COLUMNS);
            $idsSelect->columns($this->_idFieldName, 'order_grid_table');
            return $this->getConnection()->fetchCol($idsSelect, $this->_bindParams);
        } else {
            return parent::getAllIds();
        }
    }
}
