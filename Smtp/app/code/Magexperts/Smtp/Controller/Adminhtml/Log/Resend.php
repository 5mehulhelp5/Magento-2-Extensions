<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Controller\Adminhtml\Log;

use Magexperts\Smtp\Controller\RegistryConstants;

class Resend extends \Magexperts\Smtp\Controller\Adminhtml\Log
{
    /**
     * @var \Magexperts\Smtp\Model\Sender
     */
    private $sender;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magexperts\Smtp\Model\LogFactory $ruleFactory,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magexperts\Smtp\Model\Sender $sender
    ) {
        parent::__construct($context, $ruleFactory, $registry, $resultPageFactory);
        $this->sender = $sender;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $logId = $this->getRequest()->getParam(RegistryConstants::RULE_PARAM_URL_KEY);
        $log = $this->getRule();
        if ($logId) {
            try {
                if ($this->sender->sendByLogId($logId)) {
                    $this->messageManager->addSuccessMessage(__('Email successfully was send.'));
                } else {
                    $this->messageManager->addErrorMessage(__('Something went wrong.'));
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__(self::DEFAULT_ERROR_MESSAGE));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Unable to find the rule'));
        }

        return $this->_redirect($this->_redirect->getRefererUrl());
    }
}
