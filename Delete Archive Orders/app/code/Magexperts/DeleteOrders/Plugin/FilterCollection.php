<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Plugin;

use Magexperts\DeleteOrders\Model\ResourceModel\Archive\Grid\Collection as ArchiveCollection;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as OrderCollection;
use Magexperts\DeleteOrders\Model\ResourceModel\Archive as ArchiveModel;

/**
 * Class FilterCollection
 * Class provides after Plugin on Magento\Framework\View\Element\UiComponent\DataProvider\Reporting::search
 * to edit data in order grid collection
 */
class FilterCollection
{
    /**
     * After search method
     *
     * @param array $subject
     * @param array $collection
     * @return ArchiveCollection|OrderCollection|mixed
     */
    public function afterSearch($subject, $collection)
    {
        if ($collection instanceof ArchiveCollection) {
            $collection->joinSalesOrdeGridTable();
            $collection->clear()->load();
        } elseif ($collection instanceof OrderCollection) {
            $collection->getSelect()->joinLeft(
                ['archive_table' => $collection->getTable(ArchiveModel::TABLE_NAME)],
                'main_table.entity_id = archive_table.order_id',
                ['order_id']
            );
            $collection->addFieldToFilter('archive_table.order_id', ['null' => true]);
            $collection->clear()->load();
        }

        return $collection;
    }
}
