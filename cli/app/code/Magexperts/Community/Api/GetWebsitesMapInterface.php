<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Community\Api;

/**
 * Return Websites Map
 *
 * @api
 * @since 2.1.19
 */
interface GetWebsitesMapInterface
{
    /**
     * @api
     * @return array
     */
    public function execute() : array;
}
