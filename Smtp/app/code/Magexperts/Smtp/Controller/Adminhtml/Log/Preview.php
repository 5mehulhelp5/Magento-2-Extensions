<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Controller\Adminhtml\Log;

/**
 * View a rendered template.
 */
class Preview extends \Magexperts\Smtp\Controller\Adminhtml\Log
{
    /**
     * Preview Newsletter template
     *
     * @return void|$this
     */
    public function execute()
    {
        try {
            $this->_view->loadLayout();
            $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Email Preview'));
            $this->_view->renderLayout();
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('An error occurred. The email template can not be opened for preview.')
            );
            $this->_redirect('*/*/');
        }
    }
}
