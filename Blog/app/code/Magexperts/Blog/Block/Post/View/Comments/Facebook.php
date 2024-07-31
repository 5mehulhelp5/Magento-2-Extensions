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
 * Blog post Facebook comments block
 */
class Facebook extends \Magexperts\Blog\Block\Post\View\Comments
{
    /**
     * @var string
     */
    protected $commetType = CommetType::FACEBOOK;

    /**
     * @return string
     */
    public function getFbSdkJsUrl()
    {
        return '//connect.facebook.net/'.
            $this->getLocaleCode() . '/sdk.js#xfbml=1&version=v3.3&appId=' .
            $this->getFacebookAppId() . '&autoLogAppEvents=1';
    }
}
