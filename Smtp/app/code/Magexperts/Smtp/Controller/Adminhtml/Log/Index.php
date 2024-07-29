<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Controller\Adminhtml\Log;

class Index extends \Magexperts\Smtp\Controller\Adminhtml\Log
{
    /**
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->initPage();
        $resultPage->getConfig()->getTitle()->prepend(__('Emails Log'));

        return $resultPage;
    }
}
