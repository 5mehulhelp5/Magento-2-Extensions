<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml\Post;

/**
 * Class Duplicate Button Block
 */
class DuplicateButton extends \Magexperts\Community\Block\Adminhtml\Edit\DuplicateButton
{
    /**
     * @return array|string
     */
    public function getButtonData()
    {
        if (!$this->authorization->isAllowed("Magexperts_Blog::post_save")) {
            return [];
        }
        return parent::getButtonData();
    }
}
