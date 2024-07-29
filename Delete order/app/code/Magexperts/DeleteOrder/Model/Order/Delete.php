<?php
/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category   Magexperts
 * @package    Magexperts_DeleteOrder
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2019 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\DeleteOrder\Model\Order;

use Magento\Framework\App\ResourceConnection;

class Delete
{
    /**
     * @var ResourceConnection
     */
    protected $resource;
    /**
     * @var \Magexperts\DeleteOrder\Helper\Data
     */
    protected $data;

    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $order;

    /**
     * Delete constructor.
     * @param ResourceConnection $resource
     * @param \Magexperts\DeleteOrder\Helper\Data $data
     * @param \Magento\Sales\Model\Order $order
     */
    public function __construct(
        ResourceConnection $resource,
        \Magexperts\DeleteOrder\Helper\Data $data,
        \Magento\Sales\Model\Order $order
    ) {
        $this->resource = $resource;
        $this->data = $data;
        $this->order = $order;
    }

    /**
     * @param $orderId
     * @throws \Exception
     */
    public function deleteOrder($orderId)
    {
        $connection = $this->resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);

        $invoiceGridTable = $connection->getTableName($this->data->getTableName('sales_invoice_grid'));
        $shippmentGridTable = $connection->getTableName($this->data->getTableName('sales_shipment_grid'));
        $creditmemoGridTable = $connection->getTableName($this->data->getTableName('sales_creditmemo_grid'));

        $order = $this->order->load($orderId);
        $order->delete();
        $connection->rawQuery('DELETE FROM `'.$invoiceGridTable.'` WHERE order_id='.$orderId);
        $connection->rawQuery('DELETE FROM `'.$shippmentGridTable.'` WHERE order_id='.$orderId);
        $connection->rawQuery('DELETE FROM `'.$creditmemoGridTable.'` WHERE order_id='.$orderId);
    }
}
