<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
declare(strict_types=1);

namespace Magexperts\Blog\Api;

interface AuthorInterface
{
    /**
     * @param int $storeId
     * @return bool
     */
    public function isVisibleOnStore(int $storeId): bool;
}
