<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Controller\Adminhtml\Import;

/**
 * Blog available imports list controller
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * Start available import execute
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Magexperts_Blog::import');
        $title = __('Blog Import');
        $this->_view->getPage()->getConfig()->getTitle()->prepend($title);
        $this->_addBreadcrumb($title, $title);
        $this->_view->renderLayout();
    }

    /**
     * Check is allowed access
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magexperts_Blog::import');
    }
}
