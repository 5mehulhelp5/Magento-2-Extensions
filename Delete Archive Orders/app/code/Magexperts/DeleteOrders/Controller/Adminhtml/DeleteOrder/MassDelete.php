<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Controller\Adminhtml\DeleteOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magexperts\DeleteOrders\Helper\Data;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class MassDelete
 *
 * Delete multiple orders
 */
class MassDelete extends Action
{
    const ADMIN_RESOURCE = 'Magexperts_DeleteOrders::delete_action';

    /**
     * @var OrderCollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * MassDelete constructor.
     *
     * @param Context $context
     * @param OrderCollectionFactory $orderCollectionFactory
     * @param Filter $filter
     * @param Data $helper
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        OrderCollectionFactory $orderCollectionFactory,
        Filter $filter,
        Data $helper,
        Registry $registry
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->filter = $filter;
        $this->helper = $helper;
        $this->registry = $registry;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return ResponseInterface|Redirect|ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $this->registry->register('mass_action_flag', 1);
        $collection = $this->filter->getCollection($this->orderCollectionFactory->create());
        $this->registry->unregister('mass_action_flag');
        $redirectResult = $this->resultRedirectFactory->create();
        $collectionSize = $collection->getSize();
        try {
            foreach ($collection as $item) {
                $this->helper->deleteOrder($item->getId());
            }
            $this->messageManager->addSuccessMessage(__('%1 order(s) have been deleted.', $collectionSize));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        $redirectResult->setUrl($this->_redirect->getRefererUrl());
        return $redirectResult;
    }
}
