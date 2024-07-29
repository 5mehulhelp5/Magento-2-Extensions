<?php

namespace Magexperts\Core\Block;

use Magento\Framework\Data\Form\Element\AbstractElement;

class InstalledExtensions extends \Magento\Config\Block\System\Config\Form\Fieldset
{
    const AITOC_UPDATE_EXTENSION_VERSION_LINK = 'https://www.magexperts.com/customer/account/login/';
    const AITOC_PRODUCT_LINK_DEFAULT = 'https://www.magexperts.com/magento-2-extensions.html';
    const AITOC_SUPPROT_LINK = 'https://www.magexperts.com/get-support.html';

    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    protected $_moduleList;

    /**
     * @var \Magento\Framework\View\LayoutFactory
     */
    protected $_layoutFactory;

    /**
     * @var \Magexperts\Core\Helper\Extensions
     */
    private $extensionsHelper;

    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Framework\View\Helper\Js $jsHelper,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\View\LayoutFactory $layoutFactory,
        \Magexperts\Core\Helper\Extensions $extensionsHelper,
        array $data = []
    ) {
        parent::__construct($context, $authSession, $jsHelper, $data);

        $this->_moduleList    = $moduleList;
        $this->_layoutFactory = $layoutFactory;
        $this->extensionsHelper  = $extensionsHelper;
        $this->_scopeConfig   = $context->getScopeConfig();
    }

    /**
     * Render fieldset html
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $html = $this->_getHeaderHtml($element);

        $modules = $this->extensionsHelper->getMagexpertsExtensions(true);

        if ($modules) {
            foreach ($modules as $ext) {
                $html .= $this->getRenderExtensionLine($ext);
            }
        }

        $html .= $this->_getFooterHtml($element);

        return $html;
    }

    /**
     * Return footer html for fieldset
     * Add extra tooltip comments to elements
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getFooterHtml($element)
    {
        $html = '</tbody></table>';

        $html .= $this->addCommentToHtml();

        foreach ($element->getElements() as $field) {
            if ($field->getTooltip()) {
                $html .= sprintf(
                    '<div id="row_%s_comment" class="system-tooltip-box" style="display:none;">%s</div>',
                    $field->getId(),
                    $field->getTooltip()
                );
            }
        }
        $html .= '</fieldset>' . $this->_getExtraJs($element);

        if ($element->getIsNested()) {
            $html .= '</td></tr>';
        } else {
            $html .= '</div>';
        }
        return $html;
    }

    /**
     * @param $fieldset
     * @param $moduleCode
     * @return string
     */
    private function getRenderExtensionLine($extName)
    {
        $extensionsEnabled = $this->extensionsHelper->isModuleEnabled($extName);
        $resultHtml = '';
        $extInfo = $this->extensionsHelper->getExtInfo($extName);
        $packageData = [];
        $versionOld = false;
        $productUrl = self::AITOC_UPDATE_EXTENSION_VERSION_LINK;

        if (!is_array($extInfo) ||
            !array_key_exists('version', $extInfo) ||
            !array_key_exists('description', $extInfo) ||
            !array_key_exists('name', $extInfo)
        ) {
            return '';
        }

        $allExtensionsData = $this->extensionsHelper->getAllExtensions();
        if (isset($allExtensionsData[$extInfo['name']])) {
            $packageData = $allExtensionsData[$extInfo['name']];

            if ($packageData && isset($packageData['version'])) {
                $versionOld = $this->extensionsHelper
                    ->compareExtensionComposerVersions($packageData['version'], $extInfo['version']);

                if (isset($packageData['product_url']) && $packageData['product_url']) {
                    $productUrl = $packageData['product_url'];
                }
            }
        }

        $resultHtml .= '<tr id="magexperts_core_' . strtolower($extName) . '"><td class="label"><label for="magexperts_core_' .
            strtolower($extName) . '"><span><a href="' . $productUrl . '" target="_blank">'
            . str_replace('extension', '', str_replace('by Magexperts', '', $extInfo['description']))
            . '</a> (' . ($extensionsEnabled ? __('Enabled') : __('Disabled')) .  ')</span></label></td>';
        $resultHtml .= '<td class="value">'
            . $extInfo['version'] . ' '
            . '<b>' .
            ($versionOld ?
                __("(New version %1 is available in your account: ", $packageData['version'])
                . '<a class="magexperts-button-get-new-version" href="'
                . self::AITOC_UPDATE_EXTENSION_VERSION_LINK .
                '" target="_blank">' . __('Get Update') . '</a> )' : '' )
            . '</b></td>';

        return $resultHtml . '</tr>';
    }

    /**
     * @param $html
     * @return string
     */
    private function addCommentToHtml()
    {
        $html = '<div class="comment magexperts-support">';
        $html .= 'Have any issues with <b>Magexperts extensions</b>?' .
            ' Please <a href="' . self::AITOC_SUPPROT_LINK
            . '" class="magexperts-get-support-button" target="_blank">Contact Support</a>';

        return $html . '</div>';
    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface
     */
    protected function _getFieldRenderer()
    {
        if (empty($this->_fieldRenderer)) {
            $layout = $this->_layoutFactory->create();

            $this->_fieldRenderer = $layout->createBlock(
                \Magento\Config\Block\System\Config\Form\Field::class
            );
        }

        return $this->_fieldRenderer;
    }
}
