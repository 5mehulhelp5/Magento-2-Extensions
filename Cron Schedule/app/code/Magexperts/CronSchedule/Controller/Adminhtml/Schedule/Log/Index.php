<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\CronSchedule\Controller\Adminhtml\Schedule\Log;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magexperts\CronSchedule\Controller\Adminhtml\AbstractController;

class Index extends AbstractController implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ScopeConfigInterface $scopeConfigInterface
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ScopeConfigInterface $scopeConfigInterface
    ) {
        parent::__construct($context, $scopeConfigInterface);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Schedule Log'));
        return $resultPage;
    }
}
