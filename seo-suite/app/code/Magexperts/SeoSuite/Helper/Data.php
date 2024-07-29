<?php

namespace Magexperts\SeoSuite\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Module\ModuleListInterface;
use Magexperts\SeoSuite\Logger\Logger as ModuleLogger;
use Magexperts\SeoSuite\Model\Config;

/**
 * @category   Magexperts
 * @package    Magexperts_SeoSuite
 * @author     Raj KB <rajkb@Magexperts.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Data extends AbstractHelper
{
    /**
     * @var ModuleLogger
     */
    protected $moduleLogger;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        Context $context,
        ModuleLogger $moduleLogger,
        Config $config,
        StoreManagerInterface $storeManager
    ) {
        $this->moduleLogger = $moduleLogger;
        $this->config = $config;
        $this->storeManager = $storeManager;

        parent::__construct($context);
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_WEB,
            true
        );
    }

    public function isActive()
    {
        return $this->config->isEnabled();
    }

    /**
     * Logging Utility
     *
     * @param string $message
     * @param bool|false $useSeparator
     * @param bool|false $force
     */
    public function log($message, $useSeparator = false, $force = false)
    {
        if ($force
            || ($this->config->isEnabled() && $this->config->isDebugEnabled())
        ) {
            if ($useSeparator) {
                $this->moduleLogger->customLog(str_repeat('=', 100));
            }

            $this->moduleLogger->customLog($message);
        }
    }
}
