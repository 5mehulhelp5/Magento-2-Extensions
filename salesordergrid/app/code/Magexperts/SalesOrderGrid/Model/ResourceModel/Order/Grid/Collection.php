<?php
/**
 * This file is part of the Magexperts_SalesOrderGrid package.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this package
 * to newer versions in the future.
 *
 * @author   Raj KB <rajkb@Magexperts.com>
 * @license  Open Software License (OSL 3.0)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Magexperts\SalesOrderGrid\Model\ResourceModel\Order\Grid;

use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as SalesOrderGridCollection;
use Zend_Db_Expr;

class Collection extends SalesOrderGridCollection
{
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->join(
            [$this->getTable('sales_order_item')],
            "main_table.entity_id = {$this->getTable('sales_order_item')}.order_id",
            []
        );
        $this->getSelect()->group('main_table.entity_id');

        return $this;
    }

    public function addFieldToFilter($field, $condition = null)
    {
        if (!$this->getFlag('order_items_filter_added') && $field === 'purchase_items') {
            $this->getSelect()->join(
                ['purchase_item_table' => $this->getTable('sales_order_item')],
                "main_table.entity_id = purchase_item_table.order_id",
                []
            );
            $this->getSelect()->group('main_table.entity_id');

            $this->addFieldToFilter(
                [
                    "purchase_item_table.sku",
                    "purchase_item_table.name",
                ],
                [
                    $condition,
                    $condition,
                ]
            );

            $this->setFlag('order_items_filter_added', true);
            return $this;
        }

        return parent::addFieldToFilter($field, $condition);
    }

    protected function _afterLoad()
    {
        $items = $this->getColumnValues('entity_id');

        if (count($items)) {
            $connection = $this->getConnection();

            $select = $connection->select()
                ->from([
                    'sales_order_item' => $this->getTable('sales_order_item'),
                ], [
                    'order_id',
                    'item_skus'  => new Zend_Db_Expr('GROUP_CONCAT(`sales_order_item`.sku SEPARATOR "|")'),
                    'item_names' => new Zend_Db_Expr('GROUP_CONCAT(`sales_order_item`.name SEPARATOR "|")'),
                    'item_qtys'  => new Zend_Db_Expr('GROUP_CONCAT(`sales_order_item`.qty_ordered SEPARATOR "|")'),
                ])
                ->where('order_id IN (?)', $items)
                ->where('parent_item_id IS NULL')
                ->group('order_id');

            $items = $connection->fetchAll($select);
            foreach ($items as $item) {
                $row = $this->getItemById($item['order_id']);
                $itemSkus = explode('|', $item['item_skus']);
                $itemQtys = explode('|', $item['item_qtys']);
                $itemNames = explode('|', $item['item_names']);

                $html = '';
                foreach ($itemSkus as $index => $sku) {
                    $html .= sprintf('<div>%d x %s (%s) </div>', $itemQtys[$index], $itemNames[$index], $sku);
                }

                $row->setData('purchase_items', $html);
            }
        }

        return parent::_afterLoad();
    }
}
