<?php
/**
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future. If you wish to customize the module for your
 * needs please contact us to https://www.magexperts.com/contact-us.html
 *
 * @category    Ecommerce
 * @package     Magexperts_InfiniteScroll
 * @copyright   Copyright (c) 2019 Magexperts Technologies Pvt. Ltd. All Rights Reserved.
 * @url         https://www.magexperts.com/magento2-extensions/partial-payment-m2.html
 *
 **/
namespace Magexperts\InfiniteScroll\Model\Config\Source;

/**
 * Class LoadingType
 * @package Magexperts\InfiniteScroll\Model\Config\Source
 */
class LoadingType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('None')],
            ['value' => 2, 'label' => __('Automatic - on page scroll')],
            ['value' => 3, 'label' => __('Button - on button click')],
            /*['value' => 4, 'label' => __('Combined - automatic + button')],
            ['value' => 5, 'label' => __('Combined - button + automatic')]*/
        ];
    }
}
