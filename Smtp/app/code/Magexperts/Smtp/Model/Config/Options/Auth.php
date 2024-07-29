<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Model\Config\Options;

use Magento\Framework\Option\ArrayInterface;

class Auth implements ArrayInterface
{
    const AUTH_NONE = 0;
    const AUTH_LOGIN = 1;
    const AUTH_MD = 2;

    const AUTH_LOGIN_VALUE = 'login';
    const AUTH_MD_VALUE = 'md';

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => self::AUTH_NONE,
                'label' => __('Not Required')
            ],
            [
                'value' => self::AUTH_LOGIN,
                'label' => __('Login/Password')
            ],
            [
                'value' => self::AUTH_MD,
                'label' => __('CRAM-MD5')
            ]
        ];
    }

    /**
     * @param $id
     * @return string
     */
    public function getOptionById($id)
    {
        $value = '';
        switch ($id) {
            case 1:
                $value = self::AUTH_LOGIN_VALUE;
                break;
            case 2:
                $value = self::AUTH_MD_VALUE;
                break;
        }

        return $value;
    }
}
