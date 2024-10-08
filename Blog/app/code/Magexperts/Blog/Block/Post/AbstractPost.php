<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Post;

use Magento\Store\Model\ScopeInterface;

/**
 * Abstract post мшуц block
 */
abstract class AbstractPost extends \Magento\Framework\View\Element\Template
{

    /**
     * Deprecated property. Do not use it.
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * @var \Magexperts\Blog\Model\Post
     */
    protected $_post;

    /**
     * Page factory
     *
     * @var \Magexperts\Blog\Model\PostFactory
     */
    protected $_postFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var string
     */
    protected $_defaultPostInfoBlock = \Magexperts\Blog\Block\Post\Info::class;

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

    /**
     * AbstractPost constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magexperts\Blog\Model\Post $post
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Magexperts\Blog\Model\PostFactory $postFactory
     * @param \Magexperts\Blog\Model\Url $url
     * @param array $data
     * @param null $config
     * @param null $templatePool
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magexperts\Blog\Model\Post $post,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magexperts\Blog\Model\PostFactory $postFactory,
        \Magexperts\Blog\Model\Url $url,
        array $data = [],
        $config = null,
        $templatePool = null
    ) {
        parent::__construct($context, $data);
        $this->_post = $post;
        $this->_coreRegistry = $coreRegistry;
        $this->_filterProvider = $filterProvider;
        $this->_postFactory = $postFactory;
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
     * Retrieve post instance
     *
     * @return \Magexperts\Blog\Model\Post
     */
    public function getPost()
    {
        if (!$this->hasData('post')) {
            $this->setData(
                'post',
                $this->_coreRegistry->registry('current_blog_post')
            );
        }
        return $this->getData('post');
    }

    /**
     * Retrieve post short content
     *
     * @param  mixed $len
     * @param  mixed $endCharacters
     * @return string
     */
    public function getShorContent($len = null, $endCharacters = null)
    {
        return $this->getPost()->getShortFilteredContent($len, $endCharacters);
    }

    public function getShortFilteredContentWithoutImages($len = null, $endCharacters = null)
    {
        return $this->getPost()->getShortFilteredContentWithoutImages($len, $endCharacters);
    }

    /**
     * Retrieve post content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->getPost()->getFilteredContent();
    }

    /**
     * Retrieve post info html
     *
     * @return string
     */
    public function getInfoHtml()
    {
        return $this->getInfoBlock()->toHtml();
    }

    /**
     * Retrieve post info block
     *
     * @return \Magexperts\Blog\Block\Post\Info
     */
    public function getInfoBlock()
    {
        $k = 'info_block';
        if (!$this->hasData($k)) {
            $blockName = $this->getPostInfoBlockName();
            if ($blockName) {
                $block = $this->getLayout()->getBlock($blockName);
            }

            if (empty($block)) {
                $block = $this->getLayout()->createBlock($this->_defaultPostInfoBlock, uniqid(microtime()));
            }

            $this->setData($k, $block);
        }

        return $this->getData($k)->setPost($this->getPost());
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
        ) == \Magexperts\Blog\Model\Config\Source\CommetType::MAGEXPERTS;
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
     * Check if AddThis Enabled and key exist
     *
     * @return bool
     */
    public function displayAddThisToolbox()
    {
        $isSocialEnabled = $this->_scopeConfig->getValue(
            'mfblog/social/add_this_enabled',
            ScopeInterface::SCOPE_STORE
        );
        $isSocialIdExist = $this->_scopeConfig->getValue(
            'mfblog/social/add_this_pubid',
            ScopeInterface::SCOPE_STORE
        );

        return $isSocialEnabled && $isSocialIdExist;
    }
}
