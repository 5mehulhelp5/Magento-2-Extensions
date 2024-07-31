<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\Community\Api;

interface HyvaThemeDetectionInterface
{

    /**
     * @param $storeId
     * @return bool
     */
    public function execute($storeId = null): bool;

}
