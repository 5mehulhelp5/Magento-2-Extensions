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
 * @category  Magexperts
 * @package   Magexperts_FacebookPixel
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\FacebookPixel\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Tax\Model\Config
     */
    protected $taxConfig;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * Tax display flag
     *
     * @var null|int
     */
    protected $taxDisplayFlag = null;

    /**
     * Tax catalog flag
     *
     * @var null|int
     */
    protected $taxCatalogFlag = null;

    /**
     * Store object
     *
     * @var null|\Magento\Store\Model\Store
     */
    protected $store = null;

    /**
     * Store ID
     *
     * @var null|int
     */
    protected $storeId = null;

    /**
     * Base currency code
     *
     * @var null|string
     */
    protected $baseCurrencyCode = null;

    /**
     * Current currency code
     *
     * @var null|string
     */
    protected $currentCurrencyCode = null;

    /**
     * @var \Magento\Catalog\Helper\Data
     */
    protected $catalogHelper;

    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Tax\Model\Config $taxConfig
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Tax\Model\Config $taxConfig,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Catalog\Helper\Data $catalogHelper
    ) {
        $this->scopeConfig          = $context->getScopeConfig();
        $this->storeManager = $storeManager;
        $this->taxConfig = $taxConfig;
        $this->jsonEncoder = $jsonEncoder;
        $this->catalogHelper = $catalogHelper;

        parent::__construct($context);
    }

    /**
     * @param array $data
     * @return false|string
     */
    public function serializes($data)
    {
        $result = $this->jsonEncoder->encode($data);
        if (false === $result) {
            throw new \InvalidArgumentException('Unable to serialize value.');
        }
        return $result;
    }

    /**
     * @return \Magento\Tax\Model\Config
     */
    public function isTaxConfig()
    {
        return $this->taxConfig;
    }

    /**
     * @return array
     */
    public function listPageDisable()
    {
        $list = $this->returnDisablePage();
        if ($list) {
            return explode(',', $list);
        } else {
            return [];
        }
    }

    /**
     * Based on provided configuration path returns configuration value.
     *
     * @param string $configPath
     * @param string|int $scope
     * @return string
     */
    public function getConfig($configPath)
    {
        return $this->scopeConfig->getValue(
            $configPath,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @param null $scope
     * @return string
     */
    public function returnPixelId($scope = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_facebook_pixel/general/pixel_id',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * @param null $scope
     * @return mixed
     */
    public function returnDisablePage($scope = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_facebook_pixel/event_tracking/disable_code',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * @param null $scope
     * @return bool
     */
    public function isProductView($scope = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_facebook_pixel/event_tracking/product_view',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * @param null $scope
     * @return bool
     */
    public function isCategoryView($scope = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_facebook_pixel/event_tracking/category_view',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * @param null $scope
     * @return bool
     */
    public function isInitiateCheckout($scope = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_facebook_pixel/event_tracking/initiate_checkout',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * @param null $scope
     * @return bool
     */
    public function isPurchase($scope = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_facebook_pixel/event_tracking/purchase',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * @param null $scope
     * @return bool
     */
    public function isAddToWishList($scope = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_facebook_pixel/event_tracking/add_to_wishlist',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * @param null $scope
     * @return bool
     */
    public function isAddToCart($scope = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_facebook_pixel/event_tracking/add_to_cart',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * @param null $scope
     * @return bool
     */
    public function isRegistration($scope = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_facebook_pixel/event_tracking/registration',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * @param null $scope
     * @return bool
     */
    public function isSubscribe($scope = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_facebook_pixel/event_tracking/subscribe',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * @param null $scope
     * @return bool
     */
    public function isSearch($scope = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_facebook_pixel/event_tracking/search',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * @param null $scope
     * @return mixed
     */
    public function isIncludeTax($scope = null)
    {
        return $this->scopeConfig->getValue(
            'tax/calculation/price_includes_tax',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $scope
        );
    }

    /**
     * Add slashes to string and prepares string for javascript.
     *
     * @param string $str
     * @return string
     */
    public function escapeSingleQuotes($str)
    {
        return str_replace("'", "\'", $str);
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrencyCode()
    {
        return $this->storeManager->getStore()->getCurrentCurrency()->getCode();
    }

    /**
     * @param array $data
     * @return string
     */
    public function getPixelHtml($data = false)
    {
        $json = 404;
        if ($data) {
            $json =$this->serializes($data);
        }

        return $json;
    }

    /**
     * @param mixed $product
     * @return mixed|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductPrice($product)
    {
        switch ($product->getTypeId()) {
            case 'bundle':
                $price =  $this->getBundleProductPrice($product);
                break;
            case 'configurable':
                $price = $this->getConfigurableProductPrice($product);
                break;
            case 'grouped':
                $price = $this->getGroupedProductPrice($product);
                break;
            default:
                $price = $this->getFinalPrice($product);
        }

        return $price;
    }

    /**
     * Returns bundle product price.
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getBundleProductPrice($product)
    {
        $includeTax = (bool) $this->getDisplayTaxFlag();

        return $this->getFinalPrice(
            $product,
            $product->getPriceModel()->getTotalPrices(
                $product,
                'min',
                $includeTax,
                1
            )
        );
    }

    /**
     * @param  \Magento\Catalog\Model\Product $product
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getConfigurableProductPrice($product)
    {
        if ($product->getFinalPrice() === 0) {
            $simpleCollection = $product->getTypeInstance()
                ->getUsedProducts($product);

            foreach ($simpleCollection as $simpleProduct) {
                if ($simpleProduct->getPrice() > 0) {
                    return $this->getFinalPrice($simpleProduct);
                }
            }
        }

        return $this->getFinalPrice($product);
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getGroupedProductPrice($product)
    {
        $assocProducts = $product->getTypeInstance(true)
            ->getAssociatedProductCollection($product)
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('tax_class_id')
            ->addAttributeToSelect('tax_percent');

        $minPrice = INF;
        foreach ($assocProducts as $assocProduct) {
            $minPrice = min($minPrice, $this->getFinalPrice($assocProduct));
        }

        return $minPrice;
    }

    /**
     * Returns final price.
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param string $price
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getFinalPrice($product, $price = null)
    {
        $price = $this->resultPriceFinal($product, $price);

        $productType = $product->getTypeId();
        //  Apply tax if needed
        // Simple, Virtual, Downloadable products price is without tax
        // Grouped products have associated products without tax
        // Bundle products price already have tax included/excluded
        // Configurable products price already have tax included/excluded
        if ($productType != 'configurable' && $productType != 'bundle') {
            // If display tax flag is on and catalog tax flag is off
            if ($this->getDisplayTaxFlag() && !$this->getCatalogTaxFlag()) {
                $price = $this->catalogHelper->getTaxPrice(
                    $product,
                    $price,
                    true,
                    null,
                    null,
                    null,
                    $this->getStoreId(),
                    false,
                    false
                );
            }
        }

        // Case when catalog prices are with tax but display tax is set to
        // to exclude tax. Applies for all products except for bundle
        if ($productType != 'bundle') {
            // If display tax flag is off and catalog tax flag is on
            if (!$this->getDisplayTaxFlag() && $this->getCatalogTaxFlag()) {
                $price = $this->catalogHelper->getTaxPrice(
                    $product,
                    $price,
                    false,
                    null,
                    null,
                    null,
                    $this->getStoreId(),
                    true,
                    false
                );
            }
        }

        return $price;
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @param float|int $price
     * @return float
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function resultPriceFinal($product, $price)
    {
        if ($price === null) {
            $price = $product->getFinalPrice();
        }

        if ($price === null) {
            $price = $product->getData('special_price');
        }
        $productType = $product->getTypeId();
        // 1. Convert to current currency if needed

        // Convert price if base and current currency are not the same
        // Except for configurable products they already have currency converted
        if (($this->getBaseCurrencyCode() !== $this->getCurrentCurrencyCode())
            && $productType != 'configurable'
        ) {
            // Convert to from base currency to current currency
            $price = $this->getStore()->getBaseCurrency()
                ->convert($price, $this->getCurrentCurrencyCode());
        }
        return $price;
    }

    /**
     * Returns flag based on "Stores > Configuration > Sales > Tax
     * > Price Display Settings > Display Product Prices In Catalog"
     * Returns 0 or 1 instead of 1, 2, 3.
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getDisplayTaxFlag()
    {
        if ($this->taxDisplayFlag === null) {
            // Tax Display
            // 1 - excluding tax
            // 2 - including tax
            // 3 - including and excluding tax
            $flag = $this->isTaxConfig()->getPriceDisplayType($this->getStoreId());

            // 0 means price excluding tax, 1 means price including tax
            if ($flag == 1) {
                $this->taxDisplayFlag = 0;
            } else {
                $this->taxDisplayFlag = 1;
            }
        }

        return $this->taxDisplayFlag;
    }

    /**
     * Returns Stores > Configuration > Sales > Tax > Calculation Settings
     * > Catalog Prices configuration value
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getCatalogTaxFlag()
    {
        // Are catalog product prices with tax included or excluded?
        if ($this->taxCatalogFlag === null) {
            $this->taxCatalogFlag = (int) $this->isIncludeTax();
        }

        // 0 means excluded, 1 means included
        return $this->taxCatalogFlag;
    }

    /**
     * @return \Magento\Store\Api\Data\StoreInterface|\Magento\Store\Model\Store|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStore()
    {
        if ($this->store === null) {
            $this->store = $this->storeManager->getStore();
        }

        return $this->store;
    }

    /**
     * @return int|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreId()
    {
        if ($this->storeId === null) {
            $this->storeId = $this->getStore()->getId();
        }

        return $this->storeId;
    }

    /**
     * Return base currency code
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseCurrencyCode()
    {
        if ($this->baseCurrencyCode === null) {
            $this->baseCurrencyCode = strtoupper(
                $this->getStore()->getBaseCurrencyCode()
            );
        }

        return $this->baseCurrencyCode;
    }

    /**
     * Return current currency code
     * @return string|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCurrentCurrencyCode()
    {
        if ($this->currentCurrencyCode === null) {
            $this->currentCurrencyCode = strtoupper(
                $this->getStore()->getCurrentCurrencyCode()
            );
        }

        return $this->currentCurrencyCode;
    }
}
