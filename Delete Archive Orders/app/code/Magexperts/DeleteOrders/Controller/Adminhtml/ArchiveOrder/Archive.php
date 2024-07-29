<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Controller\Adminhtml\ArchiveOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magexperts\DeleteOrders\Helper\Data;

/**
 * Class Archive
 *
 * Archive orders
 */
class Archive extends Action
{
    const ADMIN_RESOURCE = 'Magexperts_DeleteOrders::archive_action';

    /**
     * @var Data
     */
    protected $helper;

    /**
     * Archive constructor.
     *
     * @param Context $context
     * @param Data $helper
     */
    public function __construct(Context $context, Data $helper)
    {
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $redirectResult = $this->resultRedirectFactory->create();
        if ($orderId = $this->getRequest()->getParam("order_id")) {
            try {
                $this->helper->archiveOrder($orderId);
                $this->messageManager->addSuccessMessage(__('Order was successfully archived'));
                $redirectResult->setPath('sales/order/view', ["order_id" => $orderId]);
                return $redirectResult;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $redirectResult->setPath('sales/order');
        return $redirectResult;
    }
}
