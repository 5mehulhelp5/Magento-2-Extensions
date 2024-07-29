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
namespace Magexperts\DeleteOrder\Controller\Adminhtml\Delete;

use Magexperts\DeleteOrder\Model\Shipment\Delete;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Model\Order\Shipment;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassShipment extends \Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction
{
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory
     */
    protected $shipmentCollectionFactory;

    /**
     * @var \Magento\Sales\Model\Order\Shipment
     */
    protected $shipment;

    /**
     * @var \Magexperts\DeleteOrder\Model\Shipment\Delete
     */
    protected $delete;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory $shipmentCollectionFactory
     * @param Shipment $shipment
     * @param Delete $delete
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory $shipmentCollectionFactory,
        \Magento\Sales\Model\Order\Shipment $shipment,
        \Magexperts\DeleteOrder\Model\Shipment\Delete $delete
    ) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
        $this->shipmentCollectionFactory = $shipmentCollectionFactory;
        $this->shipment = $shipment;
        $this->delete = $delete;
    }

    /**
     * Mass action
     *
     * @param AbstractCollection $collection
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function massAction(AbstractCollection $collection)
    {
        $params = $this->getRequest()->getParams();
        $selected = [];
        $collectionShipment = $this->filter->getCollection($this->shipmentCollectionFactory->create());
        foreach ($collectionShipment as $shipment) {
            array_push($selected, $shipment->getId());
        }
        if ($selected) {
            foreach ($selected as $shipmentId) {
                $shipment = $this->getShipmentbyId($shipmentId);
                try {
                    $order = $this->deleteShipment($shipmentId);
                    $this->messageManager->addSuccessMessage(
                        __(
                            'Successfully deleted shipment #%1.',
                            $shipment->getIncrementId()
                        )
                    );
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(
                        __(
                            'Error delete shipment #%1.',
                            $shipment->getIncrementId()
                        )
                    );
                }
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sales/shipment/');
        if ($params['namespace'] == 'sales_order_view_shipment_grid' && isset($order)) {
            $resultRedirect->setPath('sales/order/view', ['order_id' => $order->getId()]);
        } else {
            $resultRedirect->setPath('sales/shipment/');
        }
        return $resultRedirect;
    }

    /**
     * Check permission via ACL resource
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magexperts_DeleteOrder::delete_order');
    }

    /**
     * Delete shipment
     *
     * @param int $shipmentId
     * @return \Magento\Sales\Model\Order
     * @throws \Exception
     */
    protected function deleteShipment($shipmentId)
    {
        return $this->delete->deleteShipment($shipmentId);
    }

    /**
     * Get shipment by id
     *
     * @param int $shipmentId
     * @return \Magento\Sales\Model\Order\Shipment
     */
    protected function getShipmentbyId($shipmentId)
    {
        return $this->shipment->load($shipmentId);
    }
}
