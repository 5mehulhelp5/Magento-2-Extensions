<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml\Tag;

/**
 * Class Save And ContinueButton Block
 */
class SaveAndContinueButton extends \Magexperts\Community\Block\Adminhtml\Edit\SaveAndContinueButton
{
    /**
     * @return array|string
     */
    public function getButtonData()
    {
        if (!$this->authorization->isAllowed("Magexperts_Blog::tag_save")) {
            return [];
        }
        return parent::getButtonData();
    }
}
