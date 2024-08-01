<?php

namespace Magexperts\InfiniteScroll\Block;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Registry;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Backend\Block\Template\Context;

/**
 * Class Color
 * @package Magexperts\InfiniteScroll\Block
 */
class Color extends Field
{
    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * Color constructor.
     * @param $context
     * @param Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        array $data = []
    ){
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element) {
        $html = $element->getElementHtml();
        $value = $element->getData('value');
        try{
            $html = $element->getElementHtml();
            $cpPath = $this->getViewFileUrl('Magexperts_InfiniteScroll::js');
            if (!$this->_coreRegistry->registry('colorpicker_loaded')) {
                $html .= '<script type="text/javascript" src="' . $cpPath . '/' . 'jscolor.js"></script>';
                $this->_coreRegistry->registry('colorpicker_loaded', 1);
            }
            $html .= '<script type="text/javascript">
            console.log("loaded");
            var el = document.getElementById("' . $element->getHtmlId() . '");
            console.log("loaded element "+ el);
            el.className = el.className + " jscolor{hash:true}";
            console.log("loaded element class"+ el.className);
            </script>';
            return $html;
        }catch (\Exception $e){
            \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->info($e->getMessage());
        }
    }
}