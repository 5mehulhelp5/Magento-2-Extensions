<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml\Grid\Column\Filter;

/**
 * Category grid filter
 */
class Category extends \Magento\Backend\Block\Widget\Grid\Column\Filter\Select
{
    /**
     * @var \Magexperts\Blog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Framework\DB\Helper $resourceHelper
     * @param \Magexperts\Blog\Model\ResourceModel\Category\CollectionFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Framework\DB\Helper $resourceHelper,
        \Magexperts\Blog\Model\ResourceModel\Category\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $resourceHelper, $data);
    }

    /**
     * @return array
     */
    protected function _getOptions()
    {
        $options = [];
        $options[] = ['value' => '', 'label' => __('All Categories')];
        foreach ($this->collectionFactory->create()->load() as $item) {
            $options[] = ['value' => $item->getId(), 'label' => $item->getTitle()];
        };
        return $options;
    }
}
