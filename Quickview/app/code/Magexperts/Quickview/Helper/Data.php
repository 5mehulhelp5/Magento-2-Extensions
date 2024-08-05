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
 * @package    Magexperts_Quickview
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2020 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\Quickview\Helper;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var array
     */
    protected $quickviewOptions;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlInterface;

    /**
     * @var string
     */
    public $scopeStore = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

    /**
     * Data constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
        $this->scopeConfig = $context->getScopeConfig();
        $this->urlInterface = $context->getUrlBuilder();
    }

    /**
     * Btn Text color
     *
     * @return mixed|string
     */
    public function getBtnTextColor()
    {
        $color = $this->scopeConfig->getValue(
            'magexperts_quickview/success_popup_design/button_text_color',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $color = ($color == '') ? '' : $color;
        return $color;
    }

    /**
     * Btn background
     *
     * @return mixed|string
     */
    public function getBtnBackground()
    {
        $backGround = $this->scopeConfig->getValue(
            'magexperts_quickview/success_popup_design/background_color',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $backGround = ($backGround == '') ? '' : $backGround;
        return $backGround;
    }

    /**
     * Button text
     *
     * @return \Magento\Framework\Phrase|mixed
     */
    public function getButtonText()
    {
        $buttonText = $this->scopeConfig->getValue(
            'magexperts_quickview/success_popup_design/button_text',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $buttonText = ($buttonText == '') ? __('Quick View') : $buttonText;
        return $buttonText;
    }

    /**
     * Enabled module
     *
     * @return mixed|string
     */
    public function enabled()
    {
        $isEnabled = $this->scopeConfig->getValue(
            'magexperts_quickview/general/enable_product_listing',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $isEnabled = ($isEnabled == '') ? '' : $isEnabled;
        return $isEnabled;
    }

    /**
     * Get Url
     *
     * @return string
     */
    public function getUrl()
    {
        $productUrl = $this->urlInterface->getUrl('magexperts_quickview/catalog_product/view/');
        return $productUrl;
    }

    /**
     * Get base url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        $baseUrl = $this->urlInterface->getUrl();
        return $baseUrl;
    }

    /**
     * Get Enable Remove Reivews
     *
     * @return string
     */
    public function getRemoveReview()
    {
        $data = $this->scopeConfig->getValue(
            'magexperts_quickview/general/remove_reviews',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $data;
    }

    /**
     * Get Enable Remove More Information
     *
     * @return string
     */
    public function getRemoveMoreInfo()
    {
        $data = $this->scopeConfig->getValue(
            'magexperts_quickview/general/remove_product_tab',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return $data;
    }

    /**
     * Get sku template
     *
     * @return string
     */
    public function getSkuTemplate()
    {
        $this->quickviewOptions = $this->scopeConfig->getValue(
            'magexperts_quickview',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $removeSku = $this->quickviewOptions['general']['remove_sku'];
        if (!$removeSku) {
            return 'Magento_Catalog::product/view/attribute.phtml';
        }

        return '';
    }

    /**
     * Get Custom css
     *
     * @return string
     */
    public function getCustomCSS()
    {
        $this->quickviewOptions = $this->scopeConfig->getValue(
            'magexperts_quickview',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return trim($this->quickviewOptions['general']['custom_css']);
    }

    /**
     * Get close seconds
     *
     * @return int
     */
    public function getCloseSeconds()
    {
        $this->quickviewOptions = $this->scopeConfig->getValue(
            'magexperts_quickview',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        return trim($this->quickviewOptions['general']['close_quickview']);
    }

    /**
     * Get product Image
     *
     * @return mixed
     */
    public function getProductImageWrapper()
    {
        $result = $this->scopeConfig->getValue('magexperts_quickview/seting_theme/product_image_wrapper', $this->scopeStore);
        if ($result == null) {
            $result = 'product-image-wrapper';
        }
        return $result;
    }

    /**
     * Get Product Item Info
     *
     * @return mixed|string
     */
    public function getProductItemInfo()
    {
        $result = $this->scopeConfig->getValue('magexperts_quickview/seting_theme/product_item_info', $this->scopeStore);
        if ($result == null) {
            $result = 'product-item-info';
        }
        return $result;
    }
}
