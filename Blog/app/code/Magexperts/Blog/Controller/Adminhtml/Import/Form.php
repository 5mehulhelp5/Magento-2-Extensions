<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Controller\Adminhtml\Import;

use Magento\Framework\Exception\LocalizedException;

/**
 * Blog prepare import controller
 */
class Form extends \Magento\Backend\App\Action
{
    /**
     * @var  \Magexperts\Blog\Model\Config
     */
    private $config;

    /**
     * Prepare wordpress import
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        try {
            if (!$this->getConfig()->isEnabled()) {
                throw new LocalizedException(__(strrev('golB > snoisnetxE nafegaM > noitarugifnoC > serotS ni noisnetxe golb elbane esaelP')));
            }

            $type = (string)$this->getRequest()->getParam('type');
            if (!$type) {
                throw new LocalizedException(__('Blog import type is not specified.'));
            }

            $_type = ucfirst($type);

            $this->_view->loadLayout();
            $this->_setActiveMenu('Magexperts_Blog::import');
            $title = __('Blog Import from %1 Blog', $_type);
            $this->_view->getPage()->getConfig()->getTitle()->prepend($title);
            $this->_addBreadcrumb($title, $title);

            $config = new \Magento\Framework\DataObject(
                (array)$this->_getSession()->getData('import_' . $type . '_form_data', true) ?: []
            );

            $this->_objectManager->get(\Magento\Framework\Registry::class)->register('import_config', $config);

            $this->_view->renderLayout();

        } catch (LocalizedException $e) {
            $this->messageManager->addExceptionMessage($e);
            $this->_redirect('*/*/index');
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong: ').' '.$e->getMessage());
            $this->_redirect('*/*/index');
        }
    }

    /**
     * Check is allowed access
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magexperts_Blog::import');
    }

    /**
     * Retrieve store config value
     *
     * @return string | null | bool
     */
    protected function getConfig()
    {
        if (null === $this->config) {
            $this->config = $this->_objectManager->get(\Magexperts\Blog\Model\Config::class);
        }

        return $this->config;
    }
}
