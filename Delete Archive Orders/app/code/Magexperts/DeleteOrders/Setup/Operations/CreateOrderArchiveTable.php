<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Setup\Operations;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magexperts\DeleteOrders\Model\ResourceModel\Archive as ArchiveModel;
use Magexperts\DeleteOrders\Api\Data\ArchiveInterface;

/**
 * Class CreateOrderArchiveTable
 *
 * Order archive table
 */
class CreateOrderArchiveTable
{
    /**
     * Execute
     *
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    public function execute(SchemaSetupInterface $setup)
    {
        $this->createOrderArchiveTable($setup);
    }

    /**
     * Create table
     *
     * @param SchemaSetupInterface $setup
     * @throws \Zend_Db_Exception
     */
    private function createOrderArchiveTable(SchemaSetupInterface $setup)
    {
        $tableName = $setup->getTable(ArchiveModel::TABLE_NAME);
        $orderArchiveTable = $setup->getConnection()->newTable(
            $tableName
        )->addColumn(
            ArchiveInterface::RECORD_ID,
            Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ], //TODO: change to constants in 2.3.0
            'Record Id'
        )->addColumn(
            ArchiveInterface::ORDER_ID,
            Table::TYPE_INTEGER,
            null,
            ['unsigned' => true, 'nullable' => false], //TODO: change to constants in 2.3.0
            'Order Id'
        )->addColumn(
            ArchiveInterface::ARCHIVED_AT,
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT], //TODO: change to constants in 2.3.0
            'Timestamp when order was marked as arhived'
        )->addForeignKey(
            $setup->getFkName(
                ArchiveModel::TABLE_NAME,
                ArchiveInterface::ORDER_ID,
                'sales_order',
                OrderInterface::ENTITY_ID
            ),
            ArchiveInterface::ORDER_ID,
            $setup->getTable('sales_order'),
            OrderInterface::ENTITY_ID,
            AdapterInterface::FK_ACTION_CASCADE
        );

        $setup->getConnection()->createTable($orderArchiveTable);
    }
}
