<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\AutoRelatedProduct\Api;

interface ConfigInterface
{
    /**
     * Retrieve store config value
     * @param string $path
     * @param null $storeId
     * @return mixed
     */
    public function getConfig($path, $storeId = null);

    /**
     * Retrieve true if module is enabled
     *
     * @return bool
     */
    public function isEnabled($storeId = null);
}
