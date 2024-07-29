<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magexperts\Smtp\Controller\RegistryConstants;

abstract class Log extends Action
{
    const DEFAULT_ERROR_MESSAGE  = 'Something went wrong. See the error log.';

    /** @var \Magento\Framework\View\Result\PageFactory */
    protected $resultPageFactory;

    /** @var \Magento\Framework\Registry */
    protected $registry;

    /** @var \Magexperts\ShippingRules\Model\RuleFactory */
    protected $ruleFactory;

    const ADMIN_RESOURCE = 'Magexperts_Smtp::log';

    /**
     * Rule constructor.
     *
     * @param Action\Context                             $context
     * @param \Magexperts\ShippingRules\Model\RuleFactory            $ruleFactory
     * @param \Magento\Framework\Registry                $registry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magexperts\Smtp\Model\LogFactory $ruleFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->ruleFactory = $ruleFactory;
        $this->registry = $registry;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magexperts_Smtp::log');
        $resultPage->addBreadcrumb(__('Reports'), __('Reports'));
        return $resultPage;
    }

    /**
     * @param bool $requireId
     * @return \Magexperts\Smtp\Model\Log|\Magento\Framework\App\ResponseInterface
     */
    protected function getRule($requireId = false)
    {
        $ruleId = $this->getRequest()->getParam(RegistryConstants::RULE_PARAM_URL_KEY);
        if ($requireId && !$ruleId) {
            $this->messageManager->addErrorMessage(__('Log doesn\'t exist.'));
            return $this->redirectIndex();
        }

        $model = $this->ruleFactory->create();

        if ($ruleId) {
            $model->load($ruleId);
        }

        if ($ruleId && !$model->getId()) {
            $this->messageManager->addErrorMessage(__('Log doesn\'t exist.'));
            return $this->redirectIndex();
        }

        $this->registry->register(RegistryConstants::CURRENT_RULE, $model);

        return $model;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface
     */
    protected function redirectIndex()
    {
        return $this->_redirect('*/*/');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magexperts_Smtp::log');
    }
}
