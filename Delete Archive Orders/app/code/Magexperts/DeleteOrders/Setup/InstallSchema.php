<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magexperts\DeleteOrders\Setup\Operations\CreateOrderArchiveTable;
use Magexperts\DeleteOrders\Setup\Operations\CreateRulesTable;

/**
 * Class InstallSchema
 *
 * Install
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var CreateOrderArchiveTable
     */
    private $createOrderArchiveTableOperation;

    /**
     * @var CreateRulesTable
     */
    private $createRulesTableOperation;

    /**
     * InstallSchema constructor.
     *
     * @param CreateOrderArchiveTable $createOrderArchiveTableOperation
     * @param CreateRulesTable $createRulesTableOperation
     */
    public function __construct(
        CreateOrderArchiveTable $createOrderArchiveTableOperation,
        CreateRulesTable $createRulesTableOperation
    ) {
        $this->createOrderArchiveTableOperation = $createOrderArchiveTableOperation;
        $this->createRulesTableOperation = $createRulesTableOperation;
    }

    /**
     * Install
     *
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->createOrderArchiveTableOperation->execute($setup);
        $this->createRulesTableOperation->execute($setup);

        $setup->endSetup();
    }
}
