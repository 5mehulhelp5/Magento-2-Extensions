<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Controller\Adminhtml;

/**
 * Admin blog post edit controller
 */
class Post extends Actions
{
    /**
     * Form session key
     * @var string
     */
    protected $_formSessionKey  = 'blog_post_form_data';

    /**
     * Allowed Key
     * @var string
     */
    protected $_allowedKey      = 'Magexperts_Blog::post';

    /**
     * Model class name
     * @var string
     */
    protected $_modelClass      = \Magexperts\Blog\Model\Post::class;

    /**
     * Active menu key
     * @var string
     */
    protected $_activeMenu      = 'Magexperts_Blog::post';

    /**
     * Status field name
     * @var string
     */
    protected $_statusField     = 'is_active';
}
