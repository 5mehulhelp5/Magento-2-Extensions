<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Block\Adminhtml\System\Config\Form;

class InfoServerContainer extends InfoPlan
{

    /**
     * @return string
     */
    protected function getMinPlan(): string
    {
        return 'Extra';
    }

    /**
     * @return string
     */
    protected function getSectionId(): string
    {
        return 'mfgoogletagmanager_server_container';
    }

    /**
     * @return string
     */
    protected function getText(): string
    {
        return 'Server Container option is available in <strong>Extra</strong> plan only.';
    }
}
