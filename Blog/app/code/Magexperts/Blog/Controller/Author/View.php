<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Magexperts\Blog\Controller\Author;

/**
 * Blog author posts view
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
     * View blog author action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->moduleEnabled()) {
            return $this->_forwardNoroute();
        }

        $enabled = (int) $this->getConfigValue('mfblog/author/enabled');
        $pageEnabled = (int) $this->getConfigValue('mfblog/author/page_enabled');

        if (!$enabled || !$pageEnabled) {
            return $this->_forwardNoroute();
        }

        $author = $this->_initAuthor();
        if (!$author) {
            return $this->_forwardNoroute();
        }

        $this->_objectManager->get(\Magento\Framework\Registry::class)->register('current_blog_author', $author);

        $resultPage = $this->_objectManager->get(\Magexperts\Blog\Helper\Page::class)
            ->prepareResultPage($this, $author);
        return $resultPage;
    }

    /**
     * Init author
     *
     * @return \Magexperts\Blog\Api\AuthorInterface || false
     */
    protected function _initAuthor()
    {
        $id = (int)$this->getRequest()->getParam('id');
        if (!$id) {
            return false;
        }

        $storeId = $this->getStoreManager()->getStore()->getId();
        $author = $this->_objectManager->create(\Magexperts\Blog\Api\AuthorInterface::class)->load($id);

        if (!$author->isVisibleOnStore($storeId)) {
            return false;
        }

        $author->setStoreId($storeId);

        return $author;
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
