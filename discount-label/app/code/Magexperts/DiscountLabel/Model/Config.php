<?php

namespace Magexperts\DiscountLabel\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * @category   Magexperts
 * @package    Magexperts_DiscountLabel
 * @author     Raj KB <info@Magexperts.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Config implements ConfigInterface
{
    const XML_PATH_ENABLED = 'Magexperts_discountlabel/general/enabled';
    const XML_PATH_DEBUG = 'Magexperts_discountlabel/general/debug';
    const XML_PATH_CATALOG_DISCOUNT_FORMAT = 'Magexperts_discountlabel/discount/catalog_format';
    const XML_PATH_CART_DISCOUNT_FORMAT = 'Magexperts_discountlabel/discount/cart_format';

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

    public function getCatalogDisplayFormat($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CATALOG_DISCOUNT_FORMAT, $storeId);
    }

    public function getCartDisplayFormat($storeId = null)
    {
        return $this->getConfigValue(self::XML_PATH_CART_DISCOUNT_FORMAT, $storeId);
    }
}
