<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml\Category;

/**
 * Class Save And Continue Button Block
 */
class SaveAndContinueButton extends \Magexperts\Community\Block\Adminhtml\Edit\SaveAndContinueButton
{
    /**
     * @return array|string
     */
    public function getButtonData()
    {
        if (!$this->authorization->isAllowed("Magexperts_Blog::category_save")) {
            return [];
        }
        return parent::getButtonData();
    }
}
