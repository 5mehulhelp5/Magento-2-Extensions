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
 * @category  Magexperts
 * @package   Magexperts_AdminPaymentMethod
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2022 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\AdminPaymentMethod\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Api\Data\OrderItemInterface;

/**
 * Class AutoCreateInvoice
 *
 * @package Magexperts\AdminPaymentMethod\Observer
 */
class AutoCreateInvoiceandShipment implements ObserverInterface
{
    /**
     * @var \Magento\Sales\Model\Service\InvoiceService
     */
    protected $invoiceService;

    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    protected $transaction;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Sales\Model\Convert\Order
     */
    protected $convertOrder;

    /**
     * @var \Magento\Shipping\Model\ShipmentNotifier
     */
    protected $shipmentNotifier;

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var \Magento\Sales\Api\OrderItemRepositoryInterface
     */
    protected $itemRepository;

    /**
     * @var Order\Invoice\Notifier
     */
    protected $invoiceNotifier;

    /**
     * AutoCreateInvoice constructor.
     *
     * @param \Magento\Sales\Model\Service\InvoiceService $invoiceService
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\DB\TransactionFactory $transaction
     * @param \Magento\Sales\Model\Convert\Order $convertOrder
     * @param \Magento\Shipping\Model\ShipmentNotifier $shipmentNotifier
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetadata
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Sales\Api\OrderItemRepositoryInterface $itemRepository
     * @param \Magento\Sales\Model\Order\Invoice\Notifier $invoiceNotifier
     */
    public function __construct(
        \Magento\Sales\Model\Service\InvoiceService $invoiceService,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\DB\TransactionFactory $transaction,
        \Magento\Sales\Model\Convert\Order $convertOrder,
        \Magento\Shipping\Model\ShipmentNotifier $shipmentNotifier,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Sales\Api\OrderItemRepositoryInterface $itemRepository,
        \Magento\Sales\Model\Order\Invoice\Notifier $invoiceNotifier
    ) {
        $this->invoiceService = $invoiceService;
        $this->transaction = $transaction;
        $this->messageManager = $messageManager;
        $this->convertOrder = $convertOrder;
        $this->shipmentNotifier = $shipmentNotifier;
        $this->productMetadata = $productMetadata;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->itemRepository = $itemRepository;
        $this->invoiceNotifier = $invoiceNotifier;
    }

    /**
     * Execute
     *
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $payment = $order->getPayment()->getMethodInstance();

        // Check code payment method
        if ($payment->getCode() == 'adminpaymentmethod') {
            // Check option create shipment
            $this->createShipment($payment, $order);
            // Check option create invoice
            $this->createInvoice($payment, $order);
            //create notified invoice and shipment by Magexperts
            $this->displayNotified($order, $payment);
        }
    }

    /**
     * Create invoice
     *
     * @param \Magexperts\AdminPaymentMethod\Model\AdminPaymentMethod $payment
     * @param \Magento\Sales\Model\Order $order
     * @return void |null
     * @throws \Exception
     */
    private function createInvoice($payment, $order)
    {
        if ($payment->getConfigData('createinvoice')) {
            try {
                if (!$order->canInvoice() || !$order->getState() == 'new') {
                    throw new \Magento\Framework\Exception\LocalizedException(
                        __('You cant create the Invoice of this order.')
                    );
                }
                if ($this->productMetadata->getVersion() > "2.3.6") {
                    $this->setItemsOrder($order);
                }
                $invoice = $this->invoiceService->prepareInvoice($order);
                $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_ONLINE);
                $invoice->register();
                $invoice->getOrder()->setIsInProcess(true);
                $transaction = $this->transaction->create()->addObject($invoice)->addObject($invoice->getOrder());
                $transaction->save();
                $this->invoiceNotifier->notify($order, $invoice);
                //Show message create invoice
                $this->messageManager->addSuccessMessage(__("Automatically generated Invoice."));
            } catch (\Exception $e) {
                $order->addStatusHistoryComment('Exception message: ' . $e->getMessage(), false);
                $order->save();
            }
        }
    }

    /**
     * Create shipment
     *
     * @param \Magexperts\AdminPaymentMethod\Model\AdminPaymentMethod $payment
     * @param \Magento\Sales\Model\Order $order
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function createShipment($payment, $order)
    {
        if ($payment->getConfigData('createshipment')) {
            // to check order can ship or not
            if (!$order->canShip()) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('You cant create the Shipment of this order.')
                );
            }
            $orderShipment = $this->convertOrder->toShipment($order);
            if ($this->productMetadata->getVersion() > "2.3.6") {
                $this->setItemsOrder($order);
            }
            foreach ($order->getAllItems() as $orderItem) {
                // Check virtual item and item Quantity
                if (!$orderItem->getQtyToShip() || $orderItem->getIsVirtual()) {
                    continue;
                }
                $qty = $orderItem->getQtyToShip();
                $shipmentItem = $this->convertOrder->itemToShipmentItem($orderItem)->setQty($qty);

                $orderShipment->addItem($shipmentItem);
            }

            $orderShipment->register();
            $orderShipment->getOrder()->setIsInProcess(true);
            try {
                // Save created Order Shipment
                $orderShipment->save();
                $orderShipment->getOrder()->save();

                // Send Shipment Email
                $this->shipmentNotifier->notify($orderShipment);
                $orderShipment->save();

                //Show message create shipment
                $this->messageManager->addSuccessMessage(__("Automatically generated Shipment."));
            } catch (\Exception $e) {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __($e->getMessage())
                );
            }
        }
    }

    /**
     * Display notified
     *
     * @param \Magento\Sales\Model\Order $order
     * @param \Magexperts\AdminPaymentMethod\Model\AdminPaymentMethod $payment
     * @return null
     * @throws \Exception
     */
    private function displayNotified($order, $payment)
    {
        try {
            if ($payment->getConfigData('createinvoice') && $payment->getConfigData('createshipment')) {
                return $order->addStatusHistoryComment(__('Automatically Invoice and Shipment By Magexperts Invoice Shipment'))->save();
            } elseif ($payment->getConfigData('createinvoice')) {
                return $order->addStatusHistoryComment(__('Automatically Invoice By Magexperts Invoice'))->save();
            } elseif ($payment->getConfigData('createshipment')) {
                return $order->addStatusHistoryComment(__('Automatically Shipment By Magexperts Shipment'))->save();
            }
            return null;
        } catch (\Exception $e) {
            $order->addStatusHistoryComment('Exception message: ' . $e->getMessage(), false);
            $order->save();
            return null;
        }
    }

    /**
     * Set items order when send email shipping
     *
     * @param Order $order
     * @return void
     */
    public function setItemsOrder($order)
    {
        $this->searchCriteriaBuilder->addFilter(OrderItemInterface::ORDER_ID, $order->getId());
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $order->setItems($this->itemRepository->getList($searchCriteria)->getItems());
    }
}
