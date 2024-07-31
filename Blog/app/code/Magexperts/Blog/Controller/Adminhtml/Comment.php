<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Controller\Adminhtml;

/**
 * Admin blog comment edit controller
 */
class Comment extends Actions
{
    /**
     * Form session key
     * @var string
     */
    protected $_formSessionKey  = 'blog_comment_form_data';

    /**
     * Allowed Key
     * @var string
     */
    protected $_allowedKey      = 'Magexperts_Blog::comment';

    /**
     * Model class name
     * @var string
     */
    protected $_modelClass      = \Magexperts\Blog\Model\Comment::class;

    /**
     * Active menu key
     * @var string
     */
    protected $_activeMenu      = 'Magexperts_Blog::comment';

    /**
     * Status field name
     * @var string
     */
    protected $_statusField     = 'status';
}
