<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Block\DataLayer;

use Magexperts\GoogleTagManager\Block\AbstractDataLayer;

class Other extends AbstractDataLayer
{
    /**
     * Get GTM datalayer for other pages
     *
     * @return array
     */
    protected function getDataLayer(): array
    {
        return [];
    }
}
