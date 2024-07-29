<?php
namespace Magexperts\Easypathhints\Block\System\Config\Form\Field;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Version renderer with link
 *
 * @category   Magexperts
 * @package    Magexperts_Easypathhints
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    http://www.Magexperts.com
 */
class Version extends \Magento\Config\Block\System\Config\Form\Field
{
    const EXTENSION_URL = 'http://www.Magexperts.com/magento-2-easy-template-path-hints.html';

    /**
     * @var \Magexperts\Easypathhints\Helper\Data $helper
     */
    protected $_helper;

    /**
     * @param   \Magento\Backend\Block\Template\Context $context
     * @param   \Magexperts\Easypathhints\Helper\Data   $helper
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magexperts\Easypathhints\Helper\Data $helper
    ) {
        $this->_helper = $helper;
        parent::__construct($context);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        $extensionVersion = $this->_helper->getExtensionVersion();
        $extensionTitle   = 'Easy Template Path Hints';
        $versionLabel     = sprintf(
            '<a href="%s" title="%s" target="_blank">%s</a>',
            self::EXTENSION_URL,
            $extensionTitle,
            $extensionVersion
        );
        $element->setValue($versionLabel);

        return $element->getValue();
    }
}