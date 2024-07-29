<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Model\Config\Options;

use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{
    const STATUS_SUCCESS = 0;
    const STATUS_FAILED = 1;
    const STATUS_BLOCKED = 2;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::STATUS_SUCCESS,
                'label' => __('Success')
            ],
            [
                'value' => self::STATUS_FAILED,
                'label' => __('Failed')
            ],
            [
                'value' => self::STATUS_BLOCKED,
                'label' => __('Blocked')
            ]
        ];
    }

    /**
     * @param $status
     * @return mixed|string
     */
    public function getLabelByStatus($status) {
        foreach ($this->toOptionArray() as $item) {
            if ($item['value'] == $status) {
                return $item['label'];
            }
        }

        return '';
    }
}
