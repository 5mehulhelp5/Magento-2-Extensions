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

use Magento\Backend\App\Action;

class Shipment extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Sales\Model\Order\Shipment
     */
    protected $shipment;

    /**
     * @var \Magexperts\DeleteOrder\Model\Shipment\Delete
     */
    protected $delete;

    /**
     * Shipment constructor.
     * @param Action\Context $context
     * @param \Magento\Sales\Model\Order\Shipment $shipment
     * @param \Magexperts\DeleteOrder\Model\Shipment\Delete $delete
     */
    public function __construct(
        Action\Context $context,
        \Magento\Sales\Model\Order\Shipment $shipment,
        \Magexperts\DeleteOrder\Model\Shipment\Delete $delete
    ) {
        $this->shipment = $shipment;
        $this->delete = $delete;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $shipmentId = $this->getRequest()->getParam('shipment_id');
        $shipment = $this->shipment->load($shipmentId);
        try {
            $this->delete->deleteShipment($shipmentId);
            $this->messageManager->addSuccessMessage(__('Successfully deleted shipment #%1.', $shipment->getIncrementId()));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error delete shipment #%1.', $shipment->getIncrementId()));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sales/shipment/');
        return $resultRedirect;
    }

    /*
     * Check permission via ACL resource
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magexperts_DeleteOrder::delete_order');
    }
}
