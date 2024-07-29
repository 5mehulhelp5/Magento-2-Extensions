<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_GoogleReviews
 */

namespace Magexperts\GoogleReviews\Model\Source;

use Magento\Framework\Option\ArrayInterface;

class BadgePosition implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            'BOTTOM_RIGHT' => __('Bottom Right'),
            'BOTTOM_LEFT' => __('Bottom Left'),
        ];
    }
}