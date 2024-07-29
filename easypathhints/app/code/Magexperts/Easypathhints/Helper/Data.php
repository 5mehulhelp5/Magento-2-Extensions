<?php
namespace Magexperts\Easypathhints\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Module\ModuleListInterface;

/**
 * Utility Helper
 *
 * @category   Magexperts
 * @package    Magexperts_Easypathhints
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    http://www.Magexperts.com
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magexperts\Easypathhints\Logger\Logger
     */
    protected $customLogger;

    /**
     * @var \Magexperts\Easypathhints\Helper\Config
     */
    protected $configHelper;

    /**
     * @var ModuleListInterface
     */
    protected $moduleList;

    /**
     * @var \Magexperts\Easypathhints\Model\TemplateHintCookie
     */
    protected $templateHintCookie;

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $mageMetaData;

    public function __construct(
        Context $context,
        \Magexperts\Easypathhints\Logger\Logger $customLogger,
        \Magexperts\Easypathhints\Helper\Config $configHelper,
        \Magexperts\Easypathhints\Model\TemplateHintCookie $templateHintCookie,
        ModuleListInterface $moduleList,
        \Magento\Framework\App\ProductMetadataInterface $mageMetaData
    ) {
        $this->customLogger            = $customLogger;
        $this->configHelper            = $configHelper;
        $this->templateHintCookie      = $templateHintCookie;
        $this->moduleList              = $moduleList;
        $this->mageMetaData            = $mageMetaData;

        parent::__construct($context);
    }

    public function shouldShowTemplatePathHints()
    {
        if (!$this->configHelper->isActive()) {
            return false;
        }
        $tp                 = $this->_getRequest()->getParam('tp');
        $accessCode         = $this->_getRequest()->getParam('code');
        $dbAccessCode       = $this->configHelper->getAccessCode();
        $dbCookieStatus     = $this->configHelper->getSaveInCookie();
        $cookieStatus       = $this->_getRequest()->getParam('cookie', -1);

        $checkAccessCode = true;
        if ( ! empty($dbAccessCode)) {
            $checkAccessCode = ($dbAccessCode == $accessCode)
                ? true
                : false;
        }

        // set/delete cookie value
        if ($dbCookieStatus) {
            if (1 == $cookieStatus) {
                $this->templateHintCookie->set(1);
            } else if (0 == $cookieStatus) {
                $this->templateHintCookie->delete();
            }
        }

        if (  ($tp && $checkAccessCode)
            || $this->templateHintCookie->get()
        ) {
            return true;
        }

        return false;
    }

    public function getExtensionVersion()
    {
        $moduleCode = 'Magexperts_Easypathhints';
        $moduleInfo = $this->moduleList->getOne($moduleCode);
        return $moduleInfo['setup_version'];
    }

    public function getMagentoVersion()
    {
        return $this->mageMetaData->getVersion();
    }

    /**
     * Logging Utility
     *
     * @param $message
     * @param bool|false $useSeparator
     */
    public function log($message, $useSeparator = false)
    {
        if ($this->configHelper->getDebugStatus()) {
            if ($useSeparator) {
                $this->customLogger->customLog(str_repeat('=', 100));
            }

            $this->customLogger->customLog($message);
        }
    }
}