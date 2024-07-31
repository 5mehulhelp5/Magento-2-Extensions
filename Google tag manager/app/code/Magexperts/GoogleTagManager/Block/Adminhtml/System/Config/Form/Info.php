<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Block\Adminhtml\System\Config\Form;

class Info extends \Magexperts\Community\Block\Adminhtml\System\Config\Form\Info
{
    /**
     * Return extension url
     *
     * @return string
     */
    protected function getModuleUrl(): string
    {
        return 'https://mage' .
            'fan.com/magento-2-google-tag-manager?utm_source=gtm_config&utm_medium=link&utm_campaign=regular';
    }

    /**
     * Return extension title
     *
     * @return string
     */
    protected function getModuleTitle(): string
    {
        return 'Google Tag Manager and Analytics Extension';
    }
}
