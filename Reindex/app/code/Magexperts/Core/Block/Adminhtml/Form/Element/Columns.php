<?php
/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category   Magexperts
 * @package    Magexperts_Core
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\Core\Block\Adminhtml\Form\Element;

class Columns extends \Magento\Framework\Data\Form\Element\AbstractElement
{
    /**
     * Init type
     */
    protected function _construct()
    {
        $this->setType('columns');
        parent::_construct();
    }

    /**
     * Get the html.
     *
     * @return mixed
     */
    public function getHtml()
    {
        if ($this->getRequired()) {
            $this->addClass('required-entry _required');
        }

        return $this->getDefaultHtml();
    }

    /**
     * Get the default html.
     *
     * @return mixed
     */
    public function getDefaultHtml()
    {
        $html = $this->getData('default_html');
        if ($html === null) {
            $html = '<tr id="row_' . $this->getId() . '">';
            $html .= '<td class="bss-label" style="width: 35%; padding: 2.2rem 1.5rem 0 0; text-align: right;">';
            $html .= $this->getLabelHtml();
            $html .= '</td>';
            $html .= $this->getElementHtml();
            $html .= '</tr>';
        }
        return $html;
    }

    /**
     * Get the Html for the element.
     *
     * @return string
     */
    public function getElementHtml()
    {
        $columns = $this->getVersionHtml($this->getData('current_ver'));
        $columns .= $this->getVersionHtml($this->getData('latest_ver'));
        $columns .= $this->getVersionHtml($this->getData('user_guide'));

        $html = $this->getBeforeElementHtml() . $columns . $this->getAfterElementHtml();
        return $html;
    }

    /**
     * Get the html for module versions.
     *
     * @param string $value
     * @return string
     */
    protected function getVersionHtml($value)
    {
        $width = '20%';
        $html = '<td class="bss-value ' . '" style="width: ' . $width . '; padding: 2.2rem 1.5rem 0 0;">';
        $html .= "<div class='bss-version' style='text-align: center; " . "'>$value</div>";
        $html .= '</td>';

        return $html;
    }
}
