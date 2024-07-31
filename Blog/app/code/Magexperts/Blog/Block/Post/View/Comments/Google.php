<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Post\View\Comments;

use Magexperts\Blog\Model\Config\Source\CommetType;

/**
 * Blog post Google comments block
 */
class Google extends \Magexperts\Blog\Block\Post\View\Comments
{
    protected $commetType = CommetType::GOOGLE;
}
