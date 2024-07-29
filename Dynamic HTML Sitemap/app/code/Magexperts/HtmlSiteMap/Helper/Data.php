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
 * @package    MAGEXPERTS_HtmlSiteMap
 * @author     Extension Team
 * @copyright  Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\HtmlSiteMap\Helper;

use Magento\Framework\App\Helper\Context;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const MAX_PRODUCTS = 'bss_htmlsitemap/product/max_products';
    const SORT_PRODUCT = 'bss_htmlsitemap/product/sort_product';
    const ORDER_PRODUCT = 'bss_htmlsitemap/product/order_product';
    const DEFAULT_URL_KEY = 'sitemap';

    public $scopeStore = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
    /**
     * @var \Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory
     */
    private $configFactory;

    /**
     * Data constructor.
     * @param Context $context
     * @param \Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory $configFactory
     */
    public function __construct(
        Context $context,
        \Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory $configFactory
    ) {
        $this->configFactory = $configFactory;
        parent::__construct($context);
    }

    /**
     * @return mixed|string
     */
    public function getAdditionUrl()
    {
        $additionUrl = $this->scopeConfig->getValue('bss_htmlsitemap/addition/addition_link', $this->scopeStore);

        $additionUrl = ($additionUrl == '') ? '' : $additionUrl;
        return $additionUrl;
    }

    /**
     * @return mixed|string
     */
    public function getCmsLink()
    {
        $cmsLink = $this->scopeConfig->getValue('bss_htmlsitemap/cms/do_something', $this->scopeStore);

        $cmsLink = ($cmsLink == '') ? '' : $cmsLink;
        return $cmsLink;
    }

    /**
     * @return bool
     */
    public function isEnable()
    {
        $isEnable = $this->scopeConfig->isSetFlag('bss_htmlsitemap/general/enable', $this->scopeStore);
        return $isEnable;
    }

    /**
     * @param string $storeId
     * @return mixed|string
     */
    public function getModuleRoute($storeId = null)
    {
        if ($storeId) {
            $value = $this->scopeConfig->getValue('bss_htmlsitemap/general/router', $this->scopeStore, $storeId);
        } else {
            $value = $this->scopeConfig->getValue('bss_htmlsitemap/general/router', $this->scopeStore);
        }
        if (!$value) {
            $value = self::DEFAULT_URL_KEY;
        }
        return $value;
    }

    /**
     * @return mixed
     */
    public function getMaxProduct()
    {
        return $this->scopeConfig->getValue(
            self::MAX_PRODUCTS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getSortProduct()
    {
        return $this->scopeConfig->getValue(
            self::SORT_PRODUCT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getOrderProduct()
    {
        return $this->scopeConfig->getValue(
            self::ORDER_PRODUCT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getTitleSiteMap()
    {
        return $this->scopeConfig->getValue(
            "bss_htmlsitemap/general/title",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getDescriptionSitemap()
    {
        return $this->scopeConfig->getValue(
            "bss_htmlsitemap/for_search/description",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getKeywordsSitemap()
    {
        return $this->scopeConfig->getValue(
            "bss_htmlsitemap/for_search/keywords",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return mixed
     */
    public function getMetaTitleSitemap()
    {
        return $this->scopeConfig->getValue(
            "bss_htmlsitemap/for_search/meta_title",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @param int $storeId
     * @param string $path
     * @return bool|mixed
     */
    public function getConfigWithoutCache($storeId, $path)
    {
        $collection = $this->configFactory->create();
        $collection->addFieldToFilter('path', $path);

        if ((int)$storeId === 0) {
            $collection->addFieldToFilter('scope', 'default');
            $collection->addFieldToFilter('scope_id', '0');
        }
        $categoryDisable = false;
        if ($collection->getSize()) {
            $valueStoreArray = $this->getValueStore($collection, $storeId);
            $defaultValue = $valueStoreArray['default_value'];
            $categoryDisable = $valueStoreArray['store_value'];
            if ($categoryDisable === false) {
                $categoryDisable = $defaultValue;
            }
        }
        return $categoryDisable;
    }

    /**
     * @param object $collection
     * @param int $storeId
     * @return array
     */
    protected function getValueStore($collection, $storeId)
    {
        $categoryDisable = false;
        $defaultValue = '';
        foreach ($collection as $item) {
            if ((int)$storeId === 0) {
                $categoryDisable = $item->getValue();
            }
            if ((int)$item->getScopeId() === 0 && $item->getScope() == 'default') {
                $defaultValue = $item->getValue();
            }
            if ((int)$storeId !== 0 && (int)$item->getScopeId() === (int)$storeId) {
                $categoryDisable = $item->getValue();
            }
        }
        return [
            'default_value' => $defaultValue,
            'store_value' => $categoryDisable
        ];
    }

    /**
     * @param null $storeId
     * @return mixed|string
     */
    public function getCategoryDisable($storeId = null)
    {
        if ($storeId !== null) {
            $categoryDisable = $this->scopeConfig->getValue('bss_htmlsitemap/category/id_category', $this->scopeStore, $storeId);
        } else {
            $categoryDisable = $this->scopeConfig->getValue('bss_htmlsitemap/category/id_category', $this->scopeStore);
        }

        $categoryDisable = ($categoryDisable == '') ? '' : $categoryDisable;
        return $categoryDisable;
    }

    /**
     * @return bool
     */
    public function isEnableCategory()
    {
        $enableCategory = $this->scopeConfig->isSetFlag('bss_htmlsitemap/category/enable_category', $this->scopeStore);
        return $enableCategory;
    }

    /**
     * @return mixed|string
     */
    public function isEnableProduct()
    {
        $enableProduct = $this->scopeConfig->isSetFlag('bss_htmlsitemap/product/enable_product', $this->scopeStore);
        return $enableProduct;
    }

    /**
     * @return mixed|string
     */
    public function isEnableCms()
    {
        $enableCms = $this->scopeConfig->isSetFlag('bss_htmlsitemap/cms/enable_cms', $this->scopeStore);
        return $enableCms;
    }

    /**
     * @return mixed|string
     */
    public function isEnableStoreView()
    {
        $enableStoreView = $this->scopeConfig->isSetFlag('bss_htmlsitemap/store/enable_store', $this->scopeStore);
        return $enableStoreView;
    }

    /**
     * @return mixed|string
     */
    public function orderTemplates()
    {
        $orderTemplates = $this->scopeConfig->getValue('bss_htmlsitemap/general/order_templates', $this->scopeStore);

        $orderTemplates = ($orderTemplates == '') ? '' : $orderTemplates;
        return $orderTemplates;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        $baseUrl = $this->_urlBuilder->getUrl();
        return $baseUrl;
    }

    /**
     * @return mixed|string
     */
    public function titleCategory()
    {
        $titleCategory = $this->scopeConfig->getValue('bss_htmlsitemap/category/title_category', $this->scopeStore);

        $titleCategory = ($titleCategory == '') ? '' : $titleCategory;
        return $titleCategory;
    }

    /**
     * @return mixed|string
     */
    public function getShowLinkAt()
    {
        $showLinkAt = $this->scopeConfig->getValue('bss_htmlsitemap/general/show_link', $this->scopeStore);

        $showLinkAt = ($showLinkAt === '' || $showLinkAt === null) ? 'footer' : $showLinkAt;
        return $showLinkAt;
    }

    /**
     * @return mixed|string
     */
    public function titleCms()
    {
        $titleCms = $this->scopeConfig->getValue('bss_htmlsitemap/cms/title_cms', $this->scopeStore);

        $titleCms = ($titleCms == '') ? '' : $titleCms;
        return $titleCms;
    }

    /**
     * @return mixed|string
     */
    public function titleProduct()
    {
        $titleProduct = $this->scopeConfig->getValue('bss_htmlsitemap/product/title_product', $this->scopeStore);

        $titleProduct = ($titleProduct == '') ? '' : $titleProduct;
        return $titleProduct;
    }

    /**
     * @return mixed|string
     */
    public function titleStore()
    {
        $titleStore = $this->scopeConfig->getValue('bss_htmlsitemap/store/title_store', $this->scopeStore);

        $titleStore = ($titleStore == '') ? '' : $titleStore;
        return $titleStore;
    }

    /**
     * @return mixed|string
     */
    public function titleAddition()
    {
        $titleAddition = $this->scopeConfig->getValue('bss_htmlsitemap/addition/title_addition', $this->scopeStore);

        $titleAddition = ($titleAddition == '') ? '' : $titleAddition;
        return $titleAddition;
    }

    /**
     * @param string $string
     * @return mixed|string|string[]|null
     */
    public function createSlugByString($string)
    {
        if ($string === '' || $string === null) {
            return $string;
        } else {
            $unicode = [
                'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
                'd'=>'đ',
                'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
                'i'=>'í|ì|ỉ|ĩ|ị',
                'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
                'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
                'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
                'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
                'D'=>'Đ',
                'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
                'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
                'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
                'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
                'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            ];
            foreach ($unicode as $nonUnicode => $uni) {
                $string = preg_replace("/($uni)/i", $nonUnicode, $string);
            }
            //Replaces all spaces with hyphens.
            $string = str_replace(' ', '-', $string);
            // Removes special chars.
            $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);

            // Replaces multiple hyphens with single one.
            $string = preg_replace('/-+/', '-', $string);
        }
        $string = strtolower($string);
        $string = trim($string, '-');
        return $string;
    }

    /**
     * @return mixed|string
     */
    public function openNewTab()
    {
        $openNewTab = $this->scopeConfig->getValue('bss_htmlsitemap/addition/open_new_tab', $this->scopeStore);

        $openNewTab = ($openNewTab == '') ? '' : $openNewTab;
        return $openNewTab;
    }
}
