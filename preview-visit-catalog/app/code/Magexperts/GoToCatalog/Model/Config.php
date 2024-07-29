<?php

namespace Magexperts\GoToCatalog\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * @category   Magexperts
 * @package    Magexperts_GoToCatalog
 * @author     Raj KB <info@Magexperts.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Config implements ConfigInterface
{
    const XML_PATH_ENABLED = 'Magexperts_gotocatalog/general/enabled';
    const XML_PATH_DEBUG = 'Magexperts_gotocatalog/general/debug';

    const XML_PATH_ENABLE_PRODUCT_LINK = 'Magexperts_gotocatalog/catalog/enable_product_link';
    const XML_PATH_ENABLE_CATEGORY_LINK = 'Magexperts_gotocatalog/catalog/enable_category_link';
    const XML_PATH_CUSTOM_PRODUCT_URL_KEY = 'Magexperts_gotocatalog/catalog/product_url_key';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inheritDoc
     */
    public function getConfigFlag($xmlPath, $storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @inheritDoc
     */
    public function getConfigValue($xmlPath, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $xmlPath,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function isEnabled($storeId = null)
    {
        return $this->getConfigFlag(self::XML_PATH_ENABLED, $storeId);
    }

    public function isDebugEnabled($storeId = null)
    {
        return $this->getConfigFlag(self::XML_PATH_DEBUG, $storeId);
    }

    public function isProductLinkEnabled($storeId = null)
    {
        return $this->getConfigFlag(self::XML_PATH_ENABLE_PRODUCT_LINK, $storeId);
    }

    public function isCategoryLinkEnabled($storeId = null)
    {
        return $this->getConfigFlag(self::XML_PATH_ENABLE_CATEGORY_LINK, $storeId);
    }

    public function getCustomProductUrlKey($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CUSTOM_PRODUCT_URL_KEY, $storeId);
    }
}
