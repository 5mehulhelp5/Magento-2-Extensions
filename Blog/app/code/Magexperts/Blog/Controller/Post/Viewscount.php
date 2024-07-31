<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Controller\Post;

/**
 * Class Count increment views_count value
 */
class Viewscount extends View
{

    /**
     * @return $this|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute()
    {
        $post = parent::_initPost();
        if ($post && $post->getId()) {
            $post->getResource()->incrementViewsCount($post);
        }
    }
}
