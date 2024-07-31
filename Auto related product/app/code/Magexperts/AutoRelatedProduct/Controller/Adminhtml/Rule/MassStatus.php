<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\AutoRelatedProduct\Controller\Adminhtml\Rule;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\NotFoundException;
use Magento\Ui\Component\MassAction\Filter;
use Magexperts\AutoRelatedProduct\Api\RelatedCollectionInterfaceFactory as CollectionFactory;
use Magexperts\AutoRelatedProduct\Controller\Adminhtml\Rule;

/**
 * Class MassStatus
 */
class MassStatus extends Rule
{
    /**
     * MassActions filter
     *
     * @var Filter
     */
    protected $filter;

    protected $_modelClass = 'Magexperts\AutoRelatedProduct\Model\Rule';

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * MassStatus constructor.
     * @param $context
     * @param DataPersistorInterface $dataPersistor
     * @param DataPersistorInterface $dataPersistor
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->filter = $filter;
        parent::__construct($context, $dataPersistor);
    }

    /**
     * Action execute
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->getRequest()->isPost()) {
            throw new NotFoundException(__('Page not found'));
        }

        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $ruleIds = $collection->getAllIds();
        $status = (int) $this->getRequest()->getParam('status');

        try {
            foreach ($ruleIds as $id) {
                $model = $this->_objectManager->create($this->_modelClass)
                    ->load($id);
                if ($model->getId()) {
                    $model->setData('status', $status)
                    ->save();
                }
            }
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been updated.', count($ruleIds))
            );
        } catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->_getSession()->addException($e, __('Something went wrong while updating the rule(s) status.'));
        }

        $this->_redirect('*/*');
    }
}
