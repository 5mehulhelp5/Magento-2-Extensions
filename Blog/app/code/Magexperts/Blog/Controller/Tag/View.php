<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Magexperts\Blog\Controller\Tag;

use Magento\Framework\App\Action\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Blog tag posts view
 */
class View extends \Magexperts\Blog\App\Action\Action
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @var \Magexperts\Blog\Model\Url
     */
    protected $url;

    public function __construct(
        Context $context,
        \Magexperts\Blog\Model\Url $url = null
    ) {
        parent::__construct($context);
        $this->url = $url ?: $this->_objectManager->get(\Magexperts\Blog\Model\Url::class);
    }

    /**
     * View blog author action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->moduleEnabled()) {
            return $this->_forwardNoroute();
        }

        $tag = $this->_initTag();
        if (!$tag) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setHttpResponseCode(301);
            $resultRedirect->setPath($this->url->getBaseUrl());
            return $resultRedirect;
        }

        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('current_blog_tag', $tag);

        $resultPage = $this->_objectManager->get(\Magexperts\Blog\Helper\Page::class)
            ->prepareResultPage($this, $tag);

        return $resultPage;
    }

    /**
     * Init author
     *
     * @return \Magexperts\Blog\Model\Tag || false
     */
    protected function _initTag()
    {
        $id = (int)$this->getRequest()->getParam('id');
        if (!$id) {
            return false;
        }

        $storeId = $this->getStoreManager()->getStore()->getId();
        $tag = $this->_objectManager->create(\Magexperts\Blog\Model\Tag::class)->load($id);

        if (!$tag->isVisibleOnStore($storeId)) {
            return false;
        }

        $tag->setStoreId($storeId);

        return $tag;
    }

    /**
     * @return \Magento\Store\Model\StoreManagerInterface|mixed
     */
    private function getStoreManager()
    {
        if (null === $this->_storeManager) {
            $this->_storeManager = $this->_objectManager->get(\Magento\Store\Model\StoreManagerInterface::class);
        }
        return $this->_storeManager;
    }
}
