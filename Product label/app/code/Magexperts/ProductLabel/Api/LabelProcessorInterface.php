<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\ProductLabel\Api;

interface LabelProcessorInterface
{
    /**
     * @param array $replaceMap
     * @param array $productIds
     * @return array
     */
    public function execute(array $replaceMap, array $productIds): array;
}
