<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Api;

use Magento\Framework\Exception\NoSuchEntityException;

interface ContainerInterface
{
    /**
     * Generate JSON container
     *
     * @param string|null $storeId
     * @return array
     * @throws NoSuchEntityException
     */
    public function generate(string $storeId = null): array;
}
