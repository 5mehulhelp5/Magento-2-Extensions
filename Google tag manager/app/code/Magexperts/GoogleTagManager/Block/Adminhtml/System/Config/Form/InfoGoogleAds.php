<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Block\Adminhtml\System\Config\Form;

class InfoGoogleAds extends InfoPlan
{

    /**
     * @return string
     */
    protected function getMinPlan(): string
    {
        return 'Plus';
    }

    /**
     * @return string
     */
    protected function getSectionId(): string
    {
        return 'mfgoogletagmanager_ads';
    }

    /**
     * @return string
     */
    protected function getText(): string
    {
        return 'Google Ads options are available in <strong>Plus or Extra</strong> plans only.';
    }
}
