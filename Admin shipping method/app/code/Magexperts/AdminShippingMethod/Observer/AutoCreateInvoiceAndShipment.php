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
 * @package   Magexperts_AdminShippingMethod
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\AdminShippingMethod\Observer;

use Magexperts\AdminShippingMethod\Helper\Data;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Api\OrderItemRepositoryInterface;
use  Magento\Sales\Model\Order;
use Magento\Shipping\Model\ShipmentNotifier;

/**
 * Class AutoCreateInvoice
 *
 * @package Magexperts\AdminPaymentMethod\Observer
 */
class AutoCreateInvoiceAndShipment implements ObserverInterface
{
    /**
     * @var Data
     */
    protected $helper;

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
     * @var ShipmentNotifier
     */
    protected $shipmentNotifier;

    /**
     * @var ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var OrderItemRepositoryInterface
     */
    private $itemRepository;

    /**
     * AutoCreateInvoice constructor.
     * @param \Magento\Sales\Model\Service\InvoiceService $invoiceService
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\DB\TransactionFactory $transaction
     * @param \Magento\Sales\Model\Convert\Order $convertOrder
     * @param ShipmentNotifier $shipmentNotifier
     * @param ProductMetadataInterface $productMetadata
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param OrderItemRepositoryInterface $itemRepository
     */
    public function __construct(
        \Magento\Sales\Model\Service\InvoiceService $invoiceService,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\DB\TransactionFactory $transaction,
        \Magento\Sales\Model\Convert\Order $convertOrder,
        ShipmentNotifier $shipmentNotifier,
        Data $helper,
        ProductMetadataInterface $productMetadata,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        OrderItemRepositoryInterface $itemRepository
    ) {
        $this->invoiceService = $invoiceService;
        $this->transaction = $transaction;
        $this->messageManager = $messageManager;
        $this->convertOrder = $convertOrder;
        $this->shipmentNotifier = $shipmentNotifier;
        $this->helper = $helper;
        $this->productMetadata = $productMetadata;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $shipment = $order->getShippingMethod();
        $storeId = $order->getStoreId();
        // Check code payment method
        if ($shipment == 'adminshippingmethod_adminshippingmethod') {
            // Check option createshipment
            if ($this->helper->getCreatShipment($storeId)) {
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

            // Check option createinvoice
            $this->checkOptions($storeId, $order);
        }
    }

    /**
     * @param $storeId
     * @param $order
     */
    protected function checkOptions($storeId, $order)
    {
        if ($this->helper->getCreatInvoice($storeId) && $order->canInvoice()) {
            try {
                $invoice = $this->invoiceService->prepareInvoice($order);
                $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_ONLINE);
                $invoice->register();
                $invoice->getOrder()->setIsInProcess(true);
                $transaction = $this->transaction->create()->addObject($invoice)->addObject($invoice->getOrder());
                $transaction->save();

                //Show message create invoice
                $this->messageManager->addSuccessMessage(__("Automatically generated Invoice."));
            } catch (\Exception $e) {
                $order->addStatusHistoryComment('Exception message: ' . $e->getMessage(), false);
                $order->save();
            }
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
