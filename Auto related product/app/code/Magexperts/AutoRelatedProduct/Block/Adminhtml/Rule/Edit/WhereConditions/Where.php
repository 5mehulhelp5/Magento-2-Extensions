<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
namespace Magexperts\AutoRelatedProduct\Block\Adminhtml\Rule\Edit\WhereConditions;

use Magento\Framework\Data\Form\Element\AbstractElement;

class Where implements \Magento\Framework\Data\Form\Element\Renderer\RendererInterface
{
    /**
     * @param AbstractElement $element
     * @return array|string|string[]
     */
    public function render(AbstractElement $element)
    {
        $html = '';

        if ($element->getRule() && $element->getRule()->getConditions()) {
            $html = str_replace('conditions', 'actions', $element->getRule()->getConditions()->asHtmlRecursive());
        }

        return $html;
    }
}
