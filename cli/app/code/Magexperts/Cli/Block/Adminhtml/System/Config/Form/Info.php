<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\Cli\Block\Adminhtml\System\Config\Form;

class Info extends \Magexperts\Community\Block\Adminhtml\System\Config\Form\Info
{
    /**
     * Return extension url
     * @return string
     */
    protected function getModuleUrl():string
    {
        return 'https://mage' .
            'fan.com/magento2-extensions?utm_source=m2admin_cli_config&utm_medium=link&utm_campaign=regular';
    }

    /**
     * Return extension title
     * @return string
     */
    protected function getModuleTitle():string
    {
        return 'Command Line Interface';
    }
}
