<?php

namespace Magexperts\WhatsappShareM2\Model\Config\Source;

class Custom implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => 'labels',
                'label' => 'Labels',
            ],
            [
                'value' => 'dropdown',
                'label' => 'Drop Down',
            ],
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toOptionsArrayFunction2()
    {
        return [
            [
                'value' => '1',
                'label' => 'Small',
            ],
            [
                'value' => '2',
                'label' => 'Medium',
            ],
            [
                'value' => '3',
                'label' => 'Large',
            ],
        ];
    }
}