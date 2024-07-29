<?php

namespace Magexperts\ProductAttachment\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * @category   Magexperts
 * @package    Magexperts_ProductAttachment
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class FileType implements ArrayInterface
{
    protected $_options;

    public function getAllOptions($withEmpty = false)
    {
        if ($this->_options === null) {
            foreach ($this->getTypes() as $type) {
                $this->_options[] = ['value' => $type, 'label' => '.' . $type];
            }
        }
        $options = $this->_options;
        if ($withEmpty) {
            array_unshift($options, ['value' => '', 'label' => '']);
        }
        return $options;
    }

    public function getTypes()
    {
        return ['pdf', 'doc', 'docx', 'ppt', 'txt', 'jpg', 'jpeg', 'gif', 'png',  'zip', 'tar', 'gz'];
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
