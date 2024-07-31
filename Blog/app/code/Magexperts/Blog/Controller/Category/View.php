<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Magexperts\Blog\Controller\Category;

/**
 * Blog category view
 */
class View extends \Magexperts\Blog\App\Action\Action
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magexperts\Blog\Model\Url
     */
    protected $url;

    /**
     * View constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magexperts\Blog\Model\Url|null $url
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magexperts\Blog\Model\Url $url = null
    ) {
        parent::__construct($context);
        $this->_storeManager = $storeManager;
        $this->url = $url ?: $this->_objectManager->get(\Magexperts\Blog\Model\Url::class);
    }

    /**
     * View blog category action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->moduleEnabled()) {
            return $this->_forwardNoroute();
        }

        $category = $this->_initCategory();

        if (!$category) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setHttpResponseCode(301);
            $resultRedirect->setPath($this->url->getBaseUrl());
            return $resultRedirect;
        }

        $this->_objectManager->get(\Magento\Framework\Registry::class)
            ->register('current_blog_category', $category);

        $resultPage = $this->_objectManager->get(\Magexperts\Blog\Helper\Page::class)
            ->prepareResultPage($this, $category);
        return $resultPage;
    }

    /**
     * Init category
     *
     * @return \Magexperts\Blog\Model\category || false
     */
    protected function _initCategory()
    {
        $id = (int)$this->getRequest()->getParam('id');
        if (!$id) {
            return false;
        }

        $storeId = $this->_storeManager->getStore()->getId();

        $category = $this->_objectManager->create(\Magexperts\Blog\Model\Category::class)->load($id);

        if (!$category->isVisibleOnStore($storeId)) {
            return false;
        }

        $category->setStoreId($storeId);

        return $category;
    }
}
