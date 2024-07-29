<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Block\Adminhtml;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class TestButton extends Field
{

    const TEMPLATE_PATH = 'Magexperts_Smtp::config/button.phtml';
    const CHECK_BUTTON_ID = 'magexperts_send_button';

    /**
     * @param AbstractElement $element
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        /** @var \Magento\Backend\Block\Template $block */
        $block = $this->_layout->createBlock(\Magento\Backend\Block\Template::class);

        $button = $this->getLayout()->createBlock(
            \Magento\Backend\Block\Widget\Button::class
        )->setData([
            'id' => self::CHECK_BUTTON_ID,
            'label' => __('Send Test Email'),
            'class' => 'primary'
        ]);

        $block
            ->setTemplate(self::TEMPLATE_PATH)
            ->setData('send_button', $button->toHtml())
            ->setData('ajax_url', $this->getAjaxUrl())
            ->setData('button_id', self::CHECK_BUTTON_ID);

        return $block->toHtml();
    }

    /**
     * Render scope label
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _renderScopeLabel(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return '';
    }

    /**
     * @return string
     */
    private function getAjaxUrl()
    {
        return $this->getUrl('magexperts_smtp/smtp/test', ['_current' => true]);
    }


    /**
     * @return string
     */
    public function getCheckButtonId()
    {
        return self::CHECK_BUTTON_ID;
    }
}
