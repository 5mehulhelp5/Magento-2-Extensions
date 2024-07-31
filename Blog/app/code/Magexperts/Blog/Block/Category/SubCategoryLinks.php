<?php
/**
 * Copyright © 2016-Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Category;

use Magexperts\Blog\Model\Config\Source\CategoryDisplayMode;

/**
 * Blog subcategory links
 */
class SubCategoryLinks extends \Magexperts\Blog\Block\Category\AbstractCategory
{

    /**
     * @var \Magexperts\Blog\Model\ResourceModel\Category\Collection
     */
    protected $categoryCollectionFactory;

    /**
     * Construct
     * @param \Magexperts\Blog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Magexperts\Blog\Model\Url $url
     * @param array $data
     */
    public function __construct(
        \Magexperts\Blog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magexperts\Blog\Model\Url $url,
        array $data = []
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context, $coreRegistry, $filterProvider, $url, $data);
    }

    /**
     * Get subcategories
     * @return \Magexperts\Blog\Model\ResourceModel\Category\Collection
     */
    public function getSubCategories()
    {
        $subCategories = $this->categoryCollectionFactory->create();
        $subCategories
            ->addActiveFilter()
            ->addStoreFilter($this->_storeManager->getStore()->getId())
            ->setOrder('position')
            ->addFieldToFilter('category_id', ['in' => $this->getCategory()->getChildrenIds(false)]);

        return $subCategories;
    }

    /**
     * Retrieve true when display of this block is allowed
     *
     * @return bool
     */
    protected function canDisplay()
    {
        $displayMode = $this->getCategory()->getData('display_mode');
        return ($displayMode == CategoryDisplayMode::SUBCATEGORIES_LINKS
            || $displayMode == CategoryDisplayMode::POSTS_AND_SUBCATEGORIES_LINKS);
    }

    /*
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->canDisplay()) {
            return '';
        }

        return parent::_toHtml();
    }
}
