<?php
/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category   Magexperts
 * @package    MAGEXPERTS_HtmlSiteMap
 * @author     Extension Team
 * @copyright  Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\HtmlSiteMap\Block;

/**
 * Class CategoryCollection
 * @package Magexperts\HtmlSiteMap\Block
 */
class CategoryCollection extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    public $categoryCollectionFactory;

    /**
     * @var \Magento\Catalog\Helper\Category
     */
    public $categoryHelper;

    /**
     * @var $helper
     */
    public $helper;

    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    public $pageFactory;

    /**
     * ItemsCollection constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Catalog\Helper\Category $categoryHelper
     * @param \Magexperts\HtmlSiteMap\Helper\Data $helper
     * @param \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Catalog\Helper\Category $categoryHelper,
        \Magexperts\HtmlSiteMap\Helper\Data $helper,
        \Magento\Cms\Model\PageFactory $pageFactory,
        array $data = []
    ) {
        $this->pageFactory = $pageFactory;
        $this->helper = $helper;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->categoryHelper = $categoryHelper;
        parent::__construct($context, $data);
    }

    /**
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * @return \Magexperts\HtmlSiteMap\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * @param bool $isActive
     * @return \Magento\Catalog\Model\ResourceModel\Category\Collection
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCategoryCollection($isActive = true)
    {
        $rootCategoryIds = [];
        $currentWebsiteId = $this->_storeManager->getStore()->getWebsiteId();
        $stores = $this->_storeManager->getStores(false);
        foreach ($stores as $store) {
            $websiteId = $store->getWebsiteId();
            if ($currentWebsiteId == $websiteId) {
                $rootCategoryIds[] = $store->getRootCategoryId();
            }
        }
        $collection = $this->categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        // select only active categories
        if ($isActive) {
            $collection->addIsActiveFilter();
        }
        if (!empty($rootCategoryIds)) {
            $collection->addFieldToFilter('entity_id', ['in' => $rootCategoryIds]);
        }
        return $collection;
    }

    /**
     * @return \Magento\Catalog\Helper\Category
     */
    public function getCategoryHelper()
    {
        return $this->categoryHelper;
    }

    /**
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCmsPages()
    {
        $storeId = $this->getStoreId();
        $this->getStoreId();
        $collection = $this->pageFactory->create()->getCollection();
        $collection->addFieldToSelect("*");
        $collection->addStoreFilter($storeId);
        return $collection;
    }

    /**
     * @param object $category
     * @param bool $categoryDisable
     * @return string
     */
    public function getAllCategories($category, $categoryDisable)
    {
        $categoryHelper = $this->getCategoryHelper();
        $categoryHtmlEnd = null;
        if ($childrenCategories = $category->getChildrenCategories()) {
            foreach ($childrenCategories as $category) {
                if (!$category->getIsActive()) {
                    continue;
                }
                $categoryString = (string)$category->getId();
                $categoryString = "," . $categoryString . ",";
                $categoryValidate = strpos($categoryDisable, $categoryString);
                if ($categoryValidate == false) {
                    $categoryUrl = $categoryHelper->getCategoryUrl($category);
                    $categoryHtml = '<li><a href="' . $categoryUrl . '">' . $category->getName() . '</a></li>';
                    $categoryReturn = $this->getAllCategories($category, $categoryDisable);
                    $categoryHtml = $categoryHtml . $categoryReturn;
                } else {
                    $categoryHtml = null;
                }
                $categoryHtmlEnd = $categoryHtmlEnd . $categoryHtml;
            }
            return '<ul>' . $categoryHtmlEnd . '</ul>';
        }
        return '';
    }
}
