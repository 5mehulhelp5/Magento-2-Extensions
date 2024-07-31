<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Controller\Adminhtml;

/**
 * Admin blog tag edit controller
 */
class Tag extends Actions
{
    /**
     * Form session key
     * @var string
     */
    protected $_formSessionKey  = 'blog_tag_form_data';

    /**
     * Allowed Key
     * @var string
     */
    protected $_allowedKey      = 'Magexperts_Blog::tag';

    /**
     * Model class name
     * @var string
     */
    protected $_modelClass      = \Magexperts\Blog\Model\Tag::class;

    /**
     * Active menu key
     * @var string
     */
    protected $_activeMenu      = 'Magexperts_Blog::tag';

    /**
     * Status field name
     * @var string
     */
    protected $_statusField     = 'is_active';
}
