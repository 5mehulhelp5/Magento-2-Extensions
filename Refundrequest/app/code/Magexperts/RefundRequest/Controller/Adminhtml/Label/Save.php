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
 * @package    Magexperts_RefundRequest
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\RefundRequest\Controller\Adminhtml\Label;

use Magento\Backend\Model\Session;
use Magento\Framework\Registry;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magexperts\RefundRequest\Model\LabelFactory;

class Save extends Action
{
    /**
     * @var Session
     */
    protected $backendSession;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var LabelFactory
     */
    protected $labelFactory;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Save constructor.
     * @param Session $backendSession
     * @param Registry $coreRegistry
     * @param LabelFactory $labelFactory
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Session $backendSession,
        Registry $coreRegistry,
        LabelFactory $labelFactory,
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->backendSession = $backendSession;
        $this->coreRegistry = $coreRegistry;
        $this->labelFactory = $labelFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $model = $this->labelFactory->create();
        $data = $this->getRequest()->getPostValue();
        $model->setData($data);
        if ($data) {
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('The option has been saved.'));
                $this->backendSession->setPostData(false);
                if ($this->getRequest()->getParam('back')) {
                    $resultRedirect->setPath('*/*/');
                    return $resultRedirect;
                }
                $resultRedirect->setPath('*/*/');
                return $resultRedirect;
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving.'));
            }
            $this->_getSession()->setMagexpertsContactPostData($data);
            $resultRedirect->setPath('*/*/');
            return $resultRedirect;
        }
        $resultRedirect->setPath('*/*/');
        return $resultRedirect;
    }

    /**
     * Check Rule
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization
            ->isAllowed("Magexperts_RefundRequest::refundrequest_access_controller_label_save");
    }
}
