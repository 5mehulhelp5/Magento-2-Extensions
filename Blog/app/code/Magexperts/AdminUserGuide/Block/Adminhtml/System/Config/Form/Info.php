<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\AdminUserGuide\Block\Adminhtml\System\Config\Form;

/**
 * Admin user guide configurations information block
 */
class Info extends \Magexperts\Community\Block\Adminhtml\System\Config\Form\Info
{
    /**
     * Return extension url
     * @return string
     */
    protected function getModuleUrl()
    {
        return 'https://mage' . 'fan.com';
    }

    /**
     * Return extension title
     * @return string
     */
    protected function getModuleTitle()
    {
        return 'Admin User Guide Extension';
    }
}
