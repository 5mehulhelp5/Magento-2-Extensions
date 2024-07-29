<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Cron;

use Magexperts\DeleteOrders\Model\ResourceModel\Rules\CollectionFactory as RulesCollection;
use Magexperts\DeleteOrders\Model\ResourceModel\Order\CollectionFactory as OrderCollection;
use Magento\Framework\Registry;
use Magexperts\DeleteOrders\Helper\Data;

/**
 * Class OrderProcess
 *
 * Cron for orders
 */
class OrderProcess
{
    /**
     * @var RulesCollection
     */
    protected $rulesCollection;

    /**
     * @var OrderCollection
     */
    protected $orderCollection;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * OrderProcess constructor.
     *
     * @param RulesCollection $rulesCollection
     * @param OrderCollection $orderCollection
     * @param Registry $registry
     * @param Data $helper
     */
    public function __construct(
        RulesCollection $rulesCollection,
        OrderCollection $orderCollection,
        Registry $registry,
        Data $helper
    ) {
        $this->rulesCollection = $rulesCollection;
        $this->orderCollection = $orderCollection;
        $this->registry = $registry;
        $this->helper = $helper;
    }

    /**
     * Execute
     */
    public function execute()
    {
        $this->registry->register('isSecureArea', true);
        $currentDate = date("Y-m-d H:i:s");
        $rulesCollection = $this->rulesCollection->create()
            ->addFieldToFilter('is_active', 1)
            ->load();
        foreach ($rulesCollection as $rule) {
            $scope = $rule->getScope();//either sales_order_grid or archive_order_grid
            $orderStatuses = explode(",", $rule->getOrderStatuses());
            $action = $rule->getAction();//either delete or archive
            $formatDate = date('Y-m-d H:i:s', strtotime($currentDate . ' -' . $rule->getTime() . ' day'));
            if ($action == "1") {
                $this->archiveOrders($orderStatuses, $formatDate);
            } elseif ($action == "0") {
                $this->deleteOrders($scope, $orderStatuses, $formatDate);
            }
        }
        $this->registry->unregister('isSecureArea');
    }

    /**
     * Archive orders
     *
     * @param string $orderStatuses
     * @param string $formatDate
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function archiveOrders($orderStatuses, $formatDate)
    {
        $orderCollection = $this->orderCollection->create();
        //join the archive table to check whether the order has already been archived.
        $orderCollection->joinArchiveTable()
            ->addFieldToFilter('updated_at', ['lteq' => $formatDate])
            ->addFieldToFilter('status', ['in' => $orderStatuses])
            ->load();

        if ($orderCollection->getSize()) {
            foreach ($orderCollection as $order) {
                $this->helper->archiveOrder($order->getId());
            }
        }
    }

    /**
     * Delete orders
     *
     * @param string $scope
     * @param string $orderStatuses
     * @param string $formatDate
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteOrders($scope, $orderStatuses, $formatDate)
    {
        $orderCollection = $this->orderCollection->create();
        if ($scope == "1") {
            $orderCollection->addFieldToFilter('updated_at', ['lteq' => $formatDate]);
        } elseif ($scope == "0") {
            $orderCollection->joinArchiveTable(["order_id", "archived_at"], true)
                ->addFieldToFilter('archived_at', ['lteq' => $formatDate]);
        }
        $orderCollection->addFieldToFilter('status', ['in' => $orderStatuses])->load();
        if ($orderCollection->getSize()) {
            foreach ($orderCollection as $order) {
                $this->helper->deleteOrder($order->getId());
            }
        }
    }
}
