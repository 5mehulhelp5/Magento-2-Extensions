<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Community\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Community observer
 */
class PredispathAdminActionControllerObserver implements ObserverInterface
{
    /**
     * @var \Magexperts\Community\Model\AdminNotificationFeedFactory
     */
    protected $feedFactory;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $backendAuthSession;

    /**
     * @param \Magexperts\Community\Model\AdminNotificationFeedFactory $feedFactory
     * @param \Magento\Backend\Model\Auth\Session $backendAuthSession
     */
    public function __construct(
        \Magexperts\Community\Model\AdminNotificationFeedFactory $feedFactory,
        \Magento\Backend\Model\Auth\Session $backendAuthSession
    ) {
        $this->feedFactory = $feedFactory;
        $this->backendAuthSession = $backendAuthSession;
    }

    /**
     * Predispath admin action controller
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->backendAuthSession->isLoggedIn()) {
            $feedModel = $this->feedFactory->create();
            /* @var $feedModel \Magexperts\Community\Model\AdminNotificationFeed */
            $feedModel->checkUpdate();
        }
    }
}
