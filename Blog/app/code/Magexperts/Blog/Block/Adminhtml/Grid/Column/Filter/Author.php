<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml\Grid\Column\Filter;

/**
 * Author grid filter
 */
class Author extends \Magento\Backend\Block\Widget\Grid\Column\Filter\Select
{
    /**
     * @var \Magexperts\Blog\Api\AuthorCollectionInterfaceFactory
     */
    protected $collectionFactory;

    /**
     * Author constructor.
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Framework\DB\Helper $resourceHelper
     * @param \Magexperts\Blog\Api\AuthorCollectionInterfaceFactory $collectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Framework\DB\Helper $resourceHelper,
        \Magexperts\Blog\Api\AuthorCollectionInterfaceFactory $collectionFactory,
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
        $options[] = ['value' => '', 'label' => __('All Authors')];
        foreach ($this->collectionFactory->create()->load() as $item) {
            $options[] = ['value' => $item->getId(), 'label' => $item->getTitle()];
        };
        return $options;
    }
}
