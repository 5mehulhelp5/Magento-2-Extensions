<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magexperts\Blog\Model\Config\Source;

/**
 * ArchiveGroupBy
 *
 */
class ArchiveGroupBy implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @const string
     */
    const MONTH_AND_YEAR = 'month_year';

    /**
     * @const string
     */
    const YEAR = 'year';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::MONTH_AND_YEAR, 'label' => __('Month And Year')],
            ['value' => self::YEAR, 'label' => __('Year')],
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }
        return $array;
    }
}
