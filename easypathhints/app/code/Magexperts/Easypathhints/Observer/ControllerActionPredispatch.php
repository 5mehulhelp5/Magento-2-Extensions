<?php

namespace Magexperts\Easypathhints\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Config\MutableScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magexperts\Easypathhints\Helper\Data as EasypathhintsHelper;
use Magexperts\Easypathhints\Helper\Config as EasypathhintsConfigHelper;

/**
 * Observer Class
 *
 * @category   Magexperts
 * @package    Magexperts_Easypathhints
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    http://www.Magexperts.com
 */
class ControllerActionPredispatch implements ObserverInterface
{
    /**
     * @var EasypathhintsHelper $helper
     */
    protected $_helper;

    /**
     * @var MutableScopeConfigInterface
     */
    protected $_mutableConfig;

    /**
     * @param EasypathhintsHelper $helper
     * @param MutableScopeConfigInterface $mutableConfig
     */
    public function __construct(
        EasypathhintsHelper $helper,
        MutableScopeConfigInterface $mutableConfig
    ) {
        $this->_helper          = $helper;
        $this->_mutableConfig   = $mutableConfig;
    }

    public function execute(Observer $observer)
    {
        if (version_compare($this->_helper->getMagentoVersion(), '2.1.3', '>=')) {
            return $this;
        }

        if ($this->_helper->shouldShowTemplatePathHints()) {

            $this->_mutableConfig->setValue(
                EasypathhintsConfigHelper::XML_PATH_DEBUG_TEMPLATE_FRONT,
                1,
                ScopeInterface::SCOPE_STORE
            );

            $this->_mutableConfig->setValue(
                EasypathhintsConfigHelper::XML_PATH_DEBUG_TEMPLATE_ADMIN,
                1,
                ScopeInterface::SCOPE_STORE
            );

            $this->_mutableConfig->setValue(
                EasypathhintsConfigHelper::XML_PATH_DEBUG_BLOCKS,
                1,
                ScopeInterface::SCOPE_STORE
            );

            /*if ($this->_helper->getShowProfiler()) {
                $_SERVER['MAGE_PROFILER'] = 'html';
            }*/
        }
        return $this;
    }
}