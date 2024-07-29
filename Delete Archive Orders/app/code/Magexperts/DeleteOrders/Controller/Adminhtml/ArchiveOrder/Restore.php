<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Controller\Adminhtml\ArchiveOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magexperts\DeleteOrders\Model\ArchiveRepository;

/**
 * Class Restore
 *
 * Restore order
 */
class Restore extends Action
{
    const ADMIN_RESOURCE = 'Magexperts_DeleteOrders::restore_action';

    /**
     * @var ArchiveRepository
     */
    protected $archiveRepository;

    /**
     * Restore constructor.
     *
     * @param Context $context
     * @param ArchiveRepository $archiveRepository
     */
    public function __construct(Context $context, ArchiveRepository $archiveRepository)
    {
        $this->archiveRepository = $archiveRepository;
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
                $this->archiveRepository->deleteByOrderId($orderId);
                $this->messageManager->addSuccessMessage(__('Order was successfully restored'));
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
