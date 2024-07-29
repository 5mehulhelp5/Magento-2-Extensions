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

class Invoice extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Sales\Api\InvoiceRepositoryInterface
     */
    protected $invoiceRepository;

    /**
     * @var \Magexperts\DeleteOrder\Model\Invoice\Delete
     */
    protected $delete;

    /**
     * Invoice constructor.
     * @param Action\Context $context
     * @param \Magento\Sales\Api\InvoiceRepositoryInterface $invoiceRepository
     * @param \Magexperts\DeleteOrder\Model\Invoice\Delete $delete
     */
    public function __construct(
        Action\Context $context,
        \Magento\Sales\Api\InvoiceRepositoryInterface $invoiceRepository,
        \Magexperts\DeleteOrder\Model\Invoice\Delete $delete
    ) {
        $this->invoiceRepository = $invoiceRepository;
        $this->delete = $delete;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $invoiceId = $this->getRequest()->getParam('invoice_id');
        $invoice = $this->invoiceRepository->get($invoiceId);
        try {
            $this->delete->deleteInvoice($invoiceId);
            $this->messageManager->addSuccessMessage(__('Successfully deleted invoice #%1.', $invoice->getIncrementId()));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error delete invoice #%1.', $invoice->getIncrementId()));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('sales/invoice/');
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
