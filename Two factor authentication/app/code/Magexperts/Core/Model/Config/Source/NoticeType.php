<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Core
 */


namespace Magexperts\Core\Model\Config\Source;

class NoticeType implements \Magento\Framework\Option\ArrayInterface
{
    const PROMO                         = 'PROMO';
    const EXTENSION_UPDATE_CUSTOMER     = 'EXTENSION_UPDATE_CUSTOMER';
    const EXTENSION_UPDATE              = 'EXTENSION_UPDATE';
    const NEW_EXTENSION                 = 'NEW_EXTENSION';
    const NEWS                          = 'NEWS';
    const TIPS_TRICKS = 'TIPS_TRICKS';

    public function toOptionArray()
    {
        $types = [
            [
                'value' => self::NEWS,
                'label' => __('Common News')
            ],
            [
                'value' => self::PROMO,
                'label' => __('Promotions/Discounts')
            ],
            [
                'value' => self::EXTENSION_UPDATE_CUSTOMER,
                'label' => __('My Extensions Updates')
            ],
            [
                'value' => self::EXTENSION_UPDATE,
                'label' => __('All Extensions Updates')
            ],
            [
                'value' => self::NEW_EXTENSION,
                'label' => __('New Extensions')
            ],
            [
                'value' => self::TIPS_TRICKS,
                'label' => __('Magento Tricks & Tips')
            ]
        ];

        return $types;
    }
}
