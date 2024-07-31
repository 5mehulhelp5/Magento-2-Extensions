<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\ProductLabel\Api\Data;

/**
 * Interface RuleInterface
 * @package Magexperts\ProductLabel\Api\Data
 */
interface RuleInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * Get name
     * @return string|null
     */
    public function getLabelData();
}
