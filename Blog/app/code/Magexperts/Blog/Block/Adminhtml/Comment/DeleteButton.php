<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml\Comment;

/**
 * Class Delete Button Block
 */
class DeleteButton extends \Magexperts\Community\Block\Adminhtml\Edit\DeleteButton
{
    /**
     * @return array|string
     */
    public function getButtonData()
    {
        if (!$this->authorization->isAllowed("Magexperts_Blog::comment_delete")) {
            return [];
        }
        return parent::getButtonData();
    }
}
