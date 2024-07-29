<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ScopeOptionsProvider implements OptionSourceInterface
{
    const SALES_GRID_SCOPE = 1;
    const ARCHIVE_GRID_SCOPE = 0;

    /**
     * Get status options
     *
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            self::SALES_GRID_SCOPE => __('Sales Order Grid'),
            self::ARCHIVE_GRID_SCOPE => __('Archive Order Grid')
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
