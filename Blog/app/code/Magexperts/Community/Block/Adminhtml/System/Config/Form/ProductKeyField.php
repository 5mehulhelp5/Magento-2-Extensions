<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Community\Block\Adminhtml\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Backend\Block\Template\Context;
use Magexperts\Community\Model\Section;
use Magento\Framework\App\ObjectManager;

/**
 * Class Product Key Field
 */
class ProductKeyField extends Field
{
    /**
     * Retrieve HTML markup for given form element
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $fieldConfig = $element->getFieldConfig();
        $path = explode('/', $fieldConfig['path']);
        $path = $path[0];

        $section = ObjectManager::getInstance()->create(Section::class, ['name' => $path]);
        if ($section->getModule()) {
            if (!$element->getComment()) {
                $url = 'htt' . 'ps' . ':' . '/'. '/'. 'ma' . 'g' . 'ef' . 'an' . '.' . 'co'
                    . 'm/' . 'down' . 'loa' . 'dab' . 'le/' . 'cus' . 'tomer' . '/' . 'pr' . 'od' . 'ucts' . '/';
                $element->setComment('You can find product key in your <a href="' . $url . '" target="_blank">Magexperts account</a>.');
            }
            return parent::render($element);
        } else {
            return '';
        }
    }
}
