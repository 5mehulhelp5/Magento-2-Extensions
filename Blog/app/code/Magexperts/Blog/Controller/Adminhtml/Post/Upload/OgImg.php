<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Controller\Adminhtml\Post\Upload;

use Magexperts\Blog\Controller\Adminhtml\Upload\Image\Action;

/**
 * Blog featured image upload controller
 */
class OgImg extends Action
{
    /**
     * File key
     *
     * @var string
     */
    protected $_fileKey = 'og_img';

    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magexperts_Blog::post_save');
    }
}
