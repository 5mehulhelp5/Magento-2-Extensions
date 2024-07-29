<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class ActionOptionsProvider
 *
 * Options for delete actions
 */
class ActionOptionsProvider implements OptionSourceInterface
{
    const ACTION_ARCHIVE = 1;
    const ACTION_DELETE = 0;

    /**
     * Get options
     *
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            self::ACTION_ARCHIVE => __('Archive'),
            self::ACTION_DELETE => __('Delete')
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
