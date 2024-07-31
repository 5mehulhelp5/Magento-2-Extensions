<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Crowdin\Block\Adminhtml\Form;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Multiselect extends Field
{

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return parent::_getElementHtml($element) . "
        <link rel=\"stylesheet\" type=\"text/css\" href=\"" . $this->getViewFileUrl('Magexperts_Crowdin::css/chosen.min.css') . "\">
        <style type='text/css'>
            body .chosen-container.chosen-container-multi {width: 100% !important;}
            #" . $element->getId() . " {display:none}
        </style>
        <script>
            require([
                'jquery',
                'Magexperts_Crowdin/js/chosen.jquery.min',
            ], function ($, chosen) {
                $('#" . $element->getId() . "').chosen({
                    placeholder_text: '" . __('None selected') . "'
                });
            })
        </script>";
    }
}