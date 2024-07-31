<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Magexperts\Blog\Controller\Index;

/**
 * Blog home page view
 */
class Index extends \Magexperts\Blog\App\Action\Action
{
    /**
     * View blog homepage action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->moduleEnabled()) {
            return $this->_forwardNoroute();
        }

        $resultPage = $this->_objectManager->get(\Magexperts\Blog\Helper\Page::class)
            ->prepareResultPage($this, new \Magento\Framework\DataObject());
        return $resultPage;
    }
}
