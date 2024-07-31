<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Post\PostList;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Api\SortOrder;
use \Magento\Framework\View\Element\Template;
use \Magento\Framework\DataObject\IdentityInterface;

/**
 * Abstract blog post list block
 */
abstract class AbstractList extends Template implements IdentityInterface
{
    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $_post;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magexperts\Blog\Model\ResourceModel\Post\CollectionFactory
     */
    protected $_postCollectionFactory;

    /**
     * @var \Magexperts\Blog\Model\ResourceModel\Post\Collection
     */
    protected $_postCollection;

    /**
     * @var \Magexperts\Blog\Model\Url
     */
    protected $_url;

    /**
     * @var \Magexperts\Blog\Model\Config
     */
    protected $config;

    /**
     * @var \Magexperts\Blog\Model\TemplatePool
     */
    protected $templatePool;

    const POSTS_SORT_FIELD_BY_PUBLISH_TIME = 'main_table.publish_time';
    const POSTS_SORT_FIELD_BY_POSITION = 'position';
    const POSTS_SORT_FIELD_BY_TITLE = 'main_table.title';

    /**
     * AbstractList constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Magexperts\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory
     * @param \Magexperts\Blog\Model\Url $url
     * @param array $data
     * @param null $config
     * @param null $templatePool
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magexperts\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory,
        \Magexperts\Blog\Model\Url $url,
        array $data = [],
        $config = null,
        $templatePool = null
    ) {
        parent::__construct($context, $data);
        $this->_coreRegistry = $coreRegistry;
        $this->_filterProvider = $filterProvider;
        $this->_postCollectionFactory = $postCollectionFactory;
        $this->_url = $url;

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->config = $config ?: $objectManager->get(
            \Magexperts\Blog\Model\Config::class
        );
        $this->templatePool = $templatePool ?: $objectManager->get(
            \Magexperts\Blog\Model\TemplatePool::class
        );
    }

    /**
     * Prepare posts collection
     *
     * @return void
     */
    protected function _preparePostCollection()
    {
        $this->_postCollection = $this->_postCollectionFactory->create()
            ->addActiveFilter()
            ->addStoreFilter($this->_storeManager->getStore()->getId())
            ->setOrder($this->getCollectionOrderField(), $this->getCollectionOrderDirection());

        if ($this->getPageSize()) {
            $this->_postCollection->setPageSize($this->getPageSize());
        }
    }

    /**
     * Retrieve collection order field
     *
     * @return string
     */
    public function getCollectionOrderField()
    {
        return self::POSTS_SORT_FIELD_BY_PUBLISH_TIME;
    }

    /**
     * Retrieve collection order direction
     *
     * @return string
     */
    public function getCollectionOrderDirection()
    {
        return SortOrder::SORT_DESC;
    }

    /**
     * Prepare posts collection
     *
     * @return \Magexperts\Blog\Model\ResourceModel\Post\Collection
     */
    public function getPostCollection()
    {
        if (null === $this->_postCollection) {
            $this->_preparePostCollection();
        }

        return $this->_postCollection;
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->_scopeConfig->getValue(
            \Magexperts\Blog\Model\Config::XML_PATH_EXTENSION_ENABLED,
            ScopeInterface::SCOPE_STORE
        )) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * Retrieve identities
     *
     * @return array
     */
    public function getIdentities()
    {
        $identities = [];
        $identities[] = \Magexperts\Blog\Model\Post::CACHE_TAG . '_' . 0;
        foreach ($this->getPostCollection() as $item) {
            $identities = array_merge($identities, $item->getIdentities());
        }

        return array_unique($identities);
    }

    /**
     * Get cache key informative items
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        return array_merge(
            parent::getCacheKeyInfo(),
            [$this->getNameInLayout()]
        );
    }

    /**
     * Retrieve 1 if display author information is enabled
     * @return int
     */
    public function authorEnabled()
    {
        return (int) $this->_scopeConfig->getValue(
            'mfblog/author/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrieve 1 if author page is enabled
     * @return int
     */
    public function authorPageEnabled()
    {
        return (int) $this->_scopeConfig->getValue(
            'mfblog/author/page_enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrieve true if magexperts comments are enabled
     * @return bool
     */
    public function magexpertsCommentsEnabled()
    {
        return $this->_scopeConfig->getValue(
            'mfblog/post_view/comments/type',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        ) == \Magexperts\Blog\Model\Config\Source\CommetType::MAGEFAN;
    }

    /**
     * @return bool
     */
    public function viewsCountEnabled()
    {
        return (bool)$this->_scopeConfig->getValue(
            'mfblog/post_view/views_count/enabled',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return \Magexperts\Blog\ViewModel\Style
     */
    public function getStyleViewModel()
    {
        $viewModel = $this->getData('style_view_model');
        if (!$viewModel) {
            $viewModel = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(\Magexperts\Blog\ViewModel\Style::class);
            $this->setData('style_view_model', $viewModel);
        }

        return $viewModel;
    }

    /**
     * @return string
     */
    public function getPageParamName()
    {
        return $this->config->getPagePaginationType() !== 'p' ? 'page' : 'p';
    }
}
