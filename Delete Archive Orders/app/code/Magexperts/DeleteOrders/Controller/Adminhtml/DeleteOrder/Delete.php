<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Controller\Adminhtml\DeleteOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magexperts\DeleteOrders\Model\ArchiveRepository;
use Magexperts\DeleteOrders\Helper\Data;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Delete
 *
 * Delete order
 */
class Delete extends Action
{
    const ADMIN_RESOURCE = 'Magexperts_DeleteOrders::delete_action';

    /**
     * @var ArchiveRepository
     */
    protected $archiveRepository;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * Delete constructor.
     *
     * @param Context $context
     * @param ArchiveRepository $archiveRepository
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        ArchiveRepository $archiveRepository,
        Data $helper
    ) {
        $this->archiveRepository = $archiveRepository;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $redirectResult = $this->resultRedirectFactory->create();
        $redirectRoute = "sales/order";
        if ($orderId = $this->getRequest()->getParam("order_id")) {
            try {
                $archiveOrder = $this->archiveRepository->getByOrderId($orderId);
                if ($archiveOrder->getId()) {
                    $redirectRoute = "deleteorders/archiveorder";
                }
                $this->helper->deleteOrder($orderId);
                $this->messageManager->addSuccessMessage(__('Order was successfully deleted'));
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $redirectResult->setPath($redirectRoute);
        return $redirectResult;
    }
}
