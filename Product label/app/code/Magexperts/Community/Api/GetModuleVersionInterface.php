<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Community\Api;

/**
 * Return module version by module name
 *
 * @api
 * @since 2.1.0
 */
interface GetModuleVersionInterface
{
    /**
     * Get module version
     *
     * @api
     * @param string $moduleName
     * @return string
     */
    public function execute(string $moduleName) : string;
}
