<?php
/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category   Magexperts
 * @package    Magexperts_CookieNotice
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\CookieNotice\Model\Config\Source;

class Position implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @const Position
     */
    const POSITION_BOTTOM_LEFT = '0';
    const POSITION_TOP_LEFT = '1';
    const POSITION_BOTTOM_RIGHT = '2';
    const POSITION_TOP_RIGHT = '3';

    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::POSITION_BOTTOM_LEFT, 'label' => __('Bottom Left')],
            ['value' => self::POSITION_TOP_LEFT, 'label' => __('Top Left')],
            ['value' => self::POSITION_BOTTOM_RIGHT, 'label' => __('Bottom Right')],
            ['value' => self::POSITION_TOP_RIGHT, 'label' => __('Top Right')],
        ];
    }
}
