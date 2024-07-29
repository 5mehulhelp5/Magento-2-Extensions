<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Controller\Adminhtml\ArchiveOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magexperts\DeleteOrders\Helper\Data;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class MassArchive
 *
 * Archive multiple orders
 */
class MassArchive extends Action
{
    const ADMIN_RESOURCE = 'Magexperts_DeleteOrders::archive_action';

    /**
     * @var OrderCollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var $filter
     */
    protected $filter;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * MassArchive constructor.
     *
     * @param Context $context
     * @param OrderCollectionFactory $orderCollectionFactory
     * @param Filter $filter
     * @param Data $helper
     */
    public function __construct(
        Context $context,
        OrderCollectionFactory $orderCollectionFactory,
        Filter $filter,
        Data $helper
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->filter = $filter;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->orderCollectionFactory->create());
        $redirectResult = $this->resultRedirectFactory->create();
        try {
            foreach ($collection as $item) {
                $this->helper->archiveOrder($item->getId());
            }
            $this->messageManager->addSuccessMessage(
                __('%1 order(s) were successfully archived.', $collection->getSize())
            );
            $redirectResult->setPath('sales/order');
            return $redirectResult;
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $redirectResult->setPath('sales/order');
        return $redirectResult;
    }
}
