<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Controller\Adminhtml\Log;

class Delete extends \Magexperts\Smtp\Controller\Adminhtml\Log
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if ($data = $this->getRequest()->getParams()) {
            $rule = $this->getRule();

            try {
                if ($rule->getId()) {
                    $rule->delete();
                    $this->messageManager->addSuccessMessage(
                        __('Email Log has been successfully deleted')
                    );
                } else {
                    $this->messageManager->addErrorMessage(__('Unable to find the rule'));
                }
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__(self::DEFAULT_ERROR_MESSAGE));
            }
        }

        return $this->_redirect($this->_redirect->getRefererUrl());
    }
}
