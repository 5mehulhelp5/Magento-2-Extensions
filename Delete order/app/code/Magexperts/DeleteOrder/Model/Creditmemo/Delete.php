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
namespace Magexperts\DeleteOrder\Model\Creditmemo;

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
     * @var \Magento\Sales\Api\CreditmemoRepositoryInterface
     */
    protected $creditmemoRepository;

    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $order;

    /**
     * Delete constructor.
     * @param ResourceConnection $resource
     * @param \Magexperts\DeleteOrder\Helper\Data $data
     * @param \Magento\Sales\Api\CreditmemoRepositoryInterface $creditmemoRepository
     * @param \Magento\Sales\Model\Order $order
     */
    public function __construct(
        ResourceConnection $resource,
        \Magexperts\DeleteOrder\Helper\Data $data,
        \Magento\Sales\Api\CreditmemoRepositoryInterface $creditmemoRepository,
        \Magento\Sales\Model\Order $order
    ) {
        $this->resource = $resource;
        $this->data = $data;
        $this->creditmemoRepository = $creditmemoRepository;
        $this->order = $order;
    }

    /**
     * @param $creditmemoId
     * @return \Magento\Sales\Model\Order
     * @throws \Exception
     */
    public function deleteCreditmemo($creditmemoId)
    {
        $connection = $this->resource->getConnection(\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION);
        $creditmemoGridTable = $connection->getTableName($this->data->getTableName('sales_creditmemo_grid'));
        $creditmemoTable = $connection->getTableName($this->data->getTableName('sales_creditmemo'));
        $creditmemo = $this->creditmemoRepository->get($creditmemoId);
        $orderId = $creditmemo->getOrder()->getId();
        $order = $this->order->load($orderId);
        $orderItems = $order->getAllItems();
        $creditmemoItems = $creditmemo->getAllItems();
        // revert item in order
        foreach ($orderItems as $item) {
            foreach ($creditmemoItems as $creditmemoItem) {
                if ($creditmemoItem->getOrderItemId() == $item->getItemId()) {
                    $item->setQtyRefunded($item->getQtyRefunded() - $creditmemoItem->getQty());
                    $item->setTaxRefunded($item->getTaxRefunded() - $creditmemoItem->getTaxAmount());
                    $item->setBaseTaxRefunded($item->getBaseTaxRefunded() - $creditmemoItem->getBaseTaxAmount());
                    $discountTaxItem = $item->getDiscountTaxCompensationRefunded();
                    $discountTaxCredit = $creditmemoItem->getDiscountTaxCompensationAmount();
                    $item->setDiscountTaxCompensationRefunded(
                        $discountTaxItem - $discountTaxCredit
                    );
                    $baseDiscountItem = $item->getBaseDiscountTaxCompensationRefunded();
                    $baseDiscountCredit = $creditmemoItem->getBaseDiscountTaxCompensationAmount();
                    $item->setBaseDiscountTaxCompensationRefunded(
                        $baseDiscountItem - $baseDiscountCredit
                    );
                    $item->setAmountRefunded($item->getAmountRefunded() - $creditmemoItem->getRowTotal());
                    $item->setBaseAmountRefunded($item->getBaseAmountRefunded() - $creditmemoItem->getBaseRowTotal());
                    $item->setDiscountRefunded($item->getDiscountRefunded() - $creditmemoItem->getDiscountAmount());
                    $item->setBaseDiscountRefunded(
                        $item->getBaseDiscountRefunded() - $creditmemoItem->getBaseDiscountAmount()
                    );
                }
            }
        }
        // revert info in order
        $order->setBaseTotalRefunded($order->getBaseTotalRefunded() - $creditmemo->getBaseGrandTotal());
        $order->setTotalRefunded($order->getTotalRefunded() - $creditmemo->getGrandTotal());

        $order->setBaseSubtotalRefunded($order->getBaseSubtotalRefunded() - $creditmemo->getBaseSubtotal());
        $order->setSubtotalRefunded($order->getSubtotalRefunded() - $creditmemo->getSubtotal());

        $order->setBaseTaxRefunded($order->getBaseTaxRefunded() - $creditmemo->getBaseTaxAmount());
        $order->setTaxRefunded($order->getTaxRefunded() - $creditmemo->getTaxAmount());
        $order->setBaseDiscountTaxCompensationRefunded(
            $order->getBaseDiscountTaxCompensationRefunded() - $creditmemo->getBaseDiscountTaxCompensationAmount()
        );
        $order->setDiscountTaxCompensationRefunded(
            $order->getDiscountTaxCompensationRefunded() - $creditmemo->getDiscountTaxCompensationAmount()
        );

        $order->setBaseShippingRefunded($order->getBaseShippingRefunded() - $creditmemo->getBaseShippingAmount());
        $order->setShippingRefunded($order->getShippingRefunded() - $creditmemo->getShippingAmount());

        $order->setBaseShippingTaxRefunded(
            $order->getBaseShippingTaxRefunded() - $creditmemo->getBaseShippingTaxAmount()
        );
        $order->setShippingTaxRefunded($order->getShippingTaxRefunded() - $creditmemo->getShippingTaxAmount());
        $order->setAdjustmentPositive($order->getAdjustmentPositive() - $creditmemo->getAdjustmentPositive());
        $order->setBaseAdjustmentPositive(
            $order->getBaseAdjustmentPositive() - $creditmemo->getBaseAdjustmentPositive()
        );
        $order->setAdjustmentNegative($order->getAdjustmentNegative() - $creditmemo->getAdjustmentNegative());
        $order->setBaseAdjustmentNegative(
            $order->getBaseAdjustmentNegative() - $creditmemo->getBaseAdjustmentNegative()
        );
        $order->setDiscountRefunded($order->getDiscountRefunded() - $creditmemo->getDiscountAmount());
        $order->setBaseDiscountRefunded($order->getBaseDiscountRefunded() - $creditmemo->getBaseDiscountAmount());

        $this->setTotalandBaseTotal($creditmemo, $order);

        // delete creditmemo info
        $connection->rawQuery('DELETE FROM `'.$creditmemoGridTable.'` WHERE entity_id='.$creditmemoId);
        $connection->rawQuery('DELETE FROM `'.$creditmemoTable.'` WHERE entity_id='.$creditmemoId);

        $this->saveOrder($order);
        return $order;
    }

    /**
     * @param $creditmemo
     * @param $order
     */
    protected function setTotalandBaseTotal($creditmemo, $order)
    {
        if ($creditmemo->getDoTransaction()) {
            $order->setTotalOnlineRefunded($order->getTotalOnlineRefunded() - $creditmemo->getGrandTotal());
            $order->setBaseTotalOnlineRefunded($order->getBaseTotalOnlineRefunded() - $creditmemo->getBaseGrandTotal());
        } else {
            $order->setTotalOfflineRefunded($order->getTotalOfflineRefunded() - $creditmemo->getGrandTotal());
            $order->setBaseTotalOfflineRefunded(
                $order->getBaseTotalOfflineRefunded() - $creditmemo->getBaseGrandTotal()
            );
        }
    }

    /**
     * @param $order
     */
    protected function saveOrder($order)
    {
        if ($order->hasShipments() || $order->hasInvoices() || $order->hasCreditmemos()) {
            $order->setState(\Magento\Sales\Model\Order::STATE_PROCESSING)
                ->setStatus($order->getConfig()->getStateDefaultStatus(\Magento\Sales\Model\Order::STATE_PROCESSING))
                ->save();
        } elseif (!$order->canInvoice() && !$order->canShip() && !$order->hasCreditmemos()) {
            $order->setState(\Magento\Sales\Model\Order::STATE_COMPLETE)
                ->setStatus($order->getConfig()->getStateDefaultStatus(\Magento\Sales\Model\Order::STATE_COMPLETE))
                ->save();
        } else {
            $order->setState(\Magento\Sales\Model\Order::STATE_NEW)
                ->setStatus($order->getConfig()->getStateDefaultStatus(\Magento\Sales\Model\Order::STATE_NEW))
                ->save();
        }
    }
}
