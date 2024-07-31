<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Community\Api;

/**
 * Return category by product
 *
 * @api
 * @since 2.1.10
 */
interface GetCategoryByProductInterface
{
    /**
     * @param mixed $product
     * @param mixed $storeId
     * @returnmixed
     */
    public function execute($product, $storeId = null);
}
