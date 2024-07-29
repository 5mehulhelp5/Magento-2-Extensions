<?php

namespace Magexperts\DisableRegistration\Model\System\Config\Source;

/**
 * @category   Magexperts
 * @package    Magexperts_DisableRegistration
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class RegistrationOption implements \Magento\Framework\Option\ArrayInterface
{
    const ENABLED  = 1;
    const DISABLED = 0;

    protected $_options;

    public function getAllOptions($withEmpty = false)
    {
        if ($this->_options === null) {
            $this->_options = [
                [
                    'value' => self::ENABLED,
                    'label' => __('Enabled'),
                ],

                [
                    'value' => self::DISABLED,
                    'label' => __('Disabled'),
                ],
            ];

        }
        $options = $this->_options;
        if ($withEmpty) {
            array_unshift($options, ['value' => '', 'label' => '']);
        }
        return $options;
    }

    public function getOptionsArray($withEmpty = true)
    {
        $options = [];
        foreach ($this->getAllOptions($withEmpty) as $option) {
            $options[$option['value']] = $option['label'];
        }
        return $options;
    }

    public function getOptionText($value)
    {
        $options = $this->getAllOptions(false);
        foreach ($options as $item) {
            if ($item['value'] == $value) {
                return $item['label'];
            }
        }
        return false;
    }

    public function toOptionArray()
    {
        return $this->getAllOptions();
    }

    public function toOptionHash($withEmpty = true)
    {
        return $this->getOptionsArray($withEmpty);
    }
}
