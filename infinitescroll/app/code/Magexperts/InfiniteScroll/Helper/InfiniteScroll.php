<?php
/**
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future. If you wish to customize the module for your
 * needs please contact us to https://www.magexperts.com/contact-us.html
 *
 * @category    Ecommerce
 * @package     Magexperts_InfiniteScroll
 * @copyright   Copyright (c) 2019 Magexperts Technologies Pvt. Ltd. All Rights Reserved.
 * @url         https://www.magexperts.com/magento2-extensions/partial-payment-m2.html
 *
 **/
namespace Magexperts\InfiniteScroll\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;
use \AllowDynamicProperties;
#[AllowDynamicProperties]

/**
 * Class InfiniteScroll
 * @package Magexperts\InfiniteScroll\Helper
 */
class InfiniteScroll extends AbstractHelper
{
    /**
     *
     */
    const STATUS_FIELD = 'infinitescroll/license/infinitescroll_status';
    /**
     *
     */
    const LOADING_TYPE = 'infinitescroll/general/loading_type';
    /**
     *
     */
    const DISPLAY_PAGE_NUMERS = 'infinitescroll/general/display_page_number';
    /**
     *
     */
    const PAGE_NUMBERS_STYLES = 'infinitescroll/general/page_number_style';
    /**
     *
     */
    const IMAGE_PATH = 'infinitescroll/general/image_upload';
    /**
     *
     */
    const PREV_BUTTON = 'infinitescroll/load_prev_next/label_prev';
    /**
     *
     */
    const NEXT_BUTTON = 'infinitescroll/load_prev_next/label_next';
    /**
     *
     */
    const BUTTON_COLOR = 'infinitescroll/load_prev_next/button_color';
    /**
     *
     */
    const TOP_ENABLE = 'infinitescroll/back_to_top/back_to_top_status';
    /**
     *
     */
    const BUTTON_STYLE = 'infinitescroll/back_to_top/button_style';


    /**
     * @var ScopeInterface
     */
    protected $scopeConfig;
    /**
     * @var ScopeConfigInterface|ScopeInterface|mixed
     */
    protected $configModule;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * InfiniteScroll constructor.
     * @param Context $context
     * @param ScopeInterface $scopeConfig
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ){
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->configModule = $this->getConfig(strtolower($this->_getModuleName()));
        parent::__construct($context);
    }

    /**
     * @param string $cfg
     * @return ScopeConfigInterface|ScopeInterface|mixed
     */
    public function getConfig($cfg='')
    {
        if($cfg) return $this->scopeConfig->getValue($cfg, ScopeInterface::SCOPE_STORE);
        return $this->scopeConfig;
    }

    /**
     * @return mixed
     */
    public function getConfigModule()
    {
        return $this->scopeConfig->getValue(self::IMAGE_PATH,ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseUrlMedia()
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    /**
     * @return mixed
     */
    public function isEnable()
    {
        return $this->scopeConfig->getValue(self::STATUS_FIELD,ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function loadingType()
    {
        return $this->scopeConfig->getValue(self::LOADING_TYPE,ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function displayPageNUmbers()
    {
        return $this->scopeConfig->getValue(self::DISPLAY_PAGE_NUMERS,ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function pageNumbersStyle()
    {
        return $this->scopeConfig->getValue(self::PAGE_NUMBERS_STYLES,ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function prevButtonText()
    {
        return $this->scopeConfig->getValue(self::PREV_BUTTON,ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function nextButtonText()
    {
        return $this->scopeConfig->getValue(self::NEXT_BUTTON,ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function buttonColor()
    {
        return $this->scopeConfig->getValue(self::BUTTON_COLOR,ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function backToTopEnable()
    {
        return $this->scopeConfig->getValue(self::TOP_ENABLE,ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function topButtonStyle()
    {
        return $this->scopeConfig->getValue(self::BUTTON_STYLE,ScopeInterface::SCOPE_STORE);
    }
}
