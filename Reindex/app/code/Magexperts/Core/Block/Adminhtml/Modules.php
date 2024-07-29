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

namespace Magexperts\Core\Block\Adminhtml;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class Modules
 * @package Magexperts\Core\Block\Adminhtml
 */
class Modules extends \Magento\Config\Block\System\Config\Form\Fieldset
{
    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    private $layoutFactory;

    /**
     * @var \Magexperts\Core\Helper\Data
     */
    private $bssHelper;

    /**
     * @var \Magexperts\Core\Helper\Module
     */
    private $moduleHelper;

    /**
     * @var \Magento\Config\Block\System\Config\Form\Field
     */
    private $fieldRenderer;

    /**
     * Modules constructor.
     * @param \Magento\Backend\Block\Context $context
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\View\Helper\Js $jsHelper
     * @param \Magento\Framework\View\LayoutFactory $layoutFactory
     * @param \Magexperts\Core\Helper\Data $bssHelper
     * @param \Magexperts\Core\Helper\Module $moduleHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\View\Helper\Js $jsHelper,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magexperts\Core\Helper\Data $bssHelper,
        \Magexperts\Core\Helper\Module $moduleHelper,
        array $data = []
    )
    {
        parent::__construct($context, $authSession, $jsHelper, $data);
        $this->layoutFactory = $layoutFactory;
        $this->bssHelper = $bssHelper;
        $this->moduleHelper = $moduleHelper;
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $html = $this->_getHeaderHtml($element);
        $html .= $this->getTitleHtml($element);
        $localModules = $this->moduleHelper->getLocalMagexpertsModules();

        foreach ($localModules as $moduleName) {
            $html .= $this->getFieldHtml($element, $moduleName);
        }

        $html .= $this->_getFooterHtml($element);

        return $html;
    }

    /**
     * Get renderer object
     *
     * @return \Magento\Framework\View\Element\BlockInterface
     */
    protected function getFieldRenderer()
    {
        if (empty($this->fieldRenderer)) {
            $layout = $this->layoutFactory->create();

            $this->fieldRenderer = $layout->createBlock(
                \Magento\Config\Block\System\Config\Form\Field::class
            );
        }

        return $this->fieldRenderer;
    }

    /**
     * Get html of title block.
     *
     * @param AbstractElement $fieldset
     * @return mixed
     */
    protected function getTitleHtml($fieldset)
    {
        $field = $fieldset->addField(
            'module_name',
            \Magexperts\Core\Block\Adminhtml\Form\Element\Columns::class,
            [
                'name' => 'dummy',
                'label' => 'Module',
                'current_ver' => 'Current Version',
                'latest_ver' => 'Latest Version',
                'user_guide' => 'User Guide'
            ]
        )->setRenderer($this->getFieldRenderer());

        return $field->toHtml();
    }

    /**
     * Get the Html for the element.
     *
     * @param AbstractElement $fieldset
     * @param string $moduleCode
     * @return string
     */
    protected function getFieldHtml($fieldset, $moduleCode)
    {
        $localModule = $this->moduleHelper->getLocalModuleInfo($moduleCode);

        if (empty($localModule)) {
            return '';
        }

        $suite = null;
        if (isset($localModule['extra']['suite'])) {
            $suite = $localModule['extra']['suite'];
        }

        if ($this->bssHelper->isModuleEnable('Magexperts_Breadcrumbs') && $suite == 'seo-suite') {
            return '';
        }

        $moduleName = $localModule['description'];
        $apiName = $localModule['name'];

        $latestVer = 'unknown';
        $moduleUrl = '#';
        $userGuide = '';
        $module = $this->moduleHelper->searchByModule($apiName);

        if (!empty($module)) {
            $moduleName = $module['product_name'];
            $latestVer = $this->moduleHelper->getLatestVersion($module);
            $moduleUrl = $this->moduleHelper->getModuleUrl($module);
            $userGuide = $this->moduleHelper->getModuleUserGuide($module);
        }

        $moduleName = str_replace('Magexperts', '', $moduleName);
        $moduleName = str_replace('Modules', '', $moduleName);
        $moduleName = str_replace('Module', '', $moduleName);
        $moduleName = trim($moduleName);

        $latestVerCol = $latestVer == 'unknown' ? $latestVer : "<a href='$moduleUrl' target='_blank'>$latestVer</a>";

        $moduleVer = isset($localModule['extra']['suite-version']) ? $localModule['extra']['suite-version'] : $localModule['version'];
        $field = $fieldset->addField(
            $moduleCode,
            \Magexperts\Core\Block\Adminhtml\Form\Element\Columns::class,
            [
                'name' => 'dummy',
                'label' => $moduleName,
                'current_ver' => $moduleVer,
                'latest_ver' => $latestVerCol,
                'user_guide' => $userGuide
            ]
        )->setRenderer($this->getFieldRenderer());

        return $field->toHtml();
    }

    /**
     * Return header html for fieldset
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getHeaderHtml($element)
    {
        if ($element->getIsNested()) {
            $html = '<tr class="nested"><td colspan="4"><div class="' . $this->_getFrontendClass($element) . '">';
        } else {
            $html = '<div class="' . $this->_getFrontendClass($element) . '">';
        }

        $html .= '<div class="entry-edit-head admin__collapsible-block">' .
            '<span id="' .
            $element->getHtmlId() .
            '-link" class="entry-edit-head-link"></span>';

        $html .= $this->_getHeaderTitleHtml($element);

        $html .= '</div>';
        $html .= '<input id="' .
            $element->getHtmlId() .
            '-state" name="config_state[' .
            $element->getId() .
            ']" type="hidden" value="' .
            (int)$this->_isCollapseState(
                $element
            ) . '" />';
        $html .= '<fieldset class="' . $this->_getFieldsetCss() . '" id="' . $element->getHtmlId() . '">';
        $html .= '<legend>' . $element->getLegend() . '</legend>';

        $html .= $this->_getHeaderCommentHtml($element);

        // field label column
        $html .= '<table cellspacing="0" class="form-list"><colgroup class="bss-label"/><colgroup class="bss-value"/>';
        if ($this->getRequest()->getParam('website') || $this->getRequest()->getParam('store')) {
            $html .= '<colgroup class="use-default" />';
        }
        $html .= '<colgroup class="scope-label" /><colgroup class="" /><tbody>';

        return $html;
    }
}
