<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Controller\Adminhtml\Post;

/**
 * Blog post preview controller
 */
class Preview extends \Magexperts\Blog\Controller\Adminhtml\Post
{
    public function execute()
    {
        try {
            $post = $this->_getModel();
            if (!$post->getId()) {
                throw new \Exception("Item is not longer exist.", 1);
            }

            $previewUrl = $this->_objectManager->get(\Magexperts\Blog\Model\PreviewUrl::class);
            $redirectUrl = $previewUrl->getUrl(
                $post,
                $previewUrl::CONTROLLER_POST
            );

            $this->getResponse()->setRedirect($redirectUrl);
        } catch (\Exception $e) {
            $this->messageManager->addException(
                $e,
                __('Something went wrong %1', $e->getMessage())
            );
            $this->_redirect('*/*/edit', [$this->_idKey => $post->getId()]);
        }
    }
}
