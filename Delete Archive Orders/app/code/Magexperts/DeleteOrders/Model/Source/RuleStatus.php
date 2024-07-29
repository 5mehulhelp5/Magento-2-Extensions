<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class RuleStatus
 *
 * Order status rules
 */
class RuleStatus implements OptionSourceInterface
{
    const RULE_STATUS_ENABLE = 1;
    const RULE_STATUS_DISABLE = 0;

    /**
     * Get status options
     *
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            self::RULE_STATUS_ENABLE => __('Enabled'),
            self::RULE_STATUS_DISABLE => __('Disabled')
        ];
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        foreach (self::getOptionArray() as $index => $value) {
            $options[] = ['value' => $index, 'label' => $value];
        }
        return $options;
    }
}
