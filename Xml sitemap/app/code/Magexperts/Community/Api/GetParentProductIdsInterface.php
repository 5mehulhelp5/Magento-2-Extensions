<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Community\Api;

/**
 * Return parent ids by child ids
 *
 * @api
 * @since 2.1.19
 */
interface GetParentProductIdsInterface
{
    /**
     * @api
     * @param array $productIds
     * @return array
     */
    public function execute(array $productIds) : array;
}
