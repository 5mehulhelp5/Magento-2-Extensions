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
namespace Magexperts\FacebookPixel\Block;

/**
 * Class Code
 * @package Magexperts\FacebookPixel\Block
 */
class Code extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magexperts\FacebookPixel\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var \Magento\Catalog\Helper\Data
     */
    protected $catalogHelper;

    /**
     * @var \Magento\Checkout\Model\SessionFactory
     */
    protected $checkoutSession;

    /**
     * @var \Magexperts\FacebookPixel\Model\SessionFactory
     */
    protected $fbPixelSession;

    /**
     * Code constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magexperts\FacebookPixel\Helper\Data $helper
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Catalog\Helper\Data $catalogHelper
     * @param \Magento\Checkout\Model\SessionFactory $checkoutSession
     * @param \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magexperts\FacebookPixel\Helper\Data $helper,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Catalog\Helper\Data $catalogHelper,
        \Magento\Checkout\Model\SessionFactory $checkoutSession,
        \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession,
        array $data = []
    ) {
        $this->storeManager  = $context->getStoreManager();
        $this->helper        = $helper;
        $this->coreRegistry  = $coreRegistry;
        $this->catalogHelper = $catalogHelper;
        $this->checkoutSession = $checkoutSession;
        $this->fbPixelSession = $fbPixelSession;
        parent::__construct($context, $data);
    }

    /**
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function checkDisable()
    {
        $data   = $this->getFacebookPixelData();
        $action = $data['full_action_name'];
        $listDisableCode = $this->helper->listPageDisable();
        if (($action == 'checkout_onepage_success'
                || $action == 'onepagecheckout_index_success') && in_array('success_page', $listDisableCode)) {
            return 404;
        } elseif ($action == 'customer_account_index' && in_array('account_page', $listDisableCode)) {
            return 404;
        } elseif (($action == 'cms_index_index' || $action == 'cms_page_view')
            && in_array('cms_page', $listDisableCode)) {
            return 404;
        } else {
            return $this->checkDisableMore($action, $listDisableCode);
        }
    }

    /**
     * @param  string $action
     * @param array $listDisableCode
     * @return int
     */
    private function checkDisableMore($action, $listDisableCode)
    {
        $arrCheckout = [
            'checkout_index_index',
            'onepagecheckout_index_index',
            'onestepcheckout_index_index',
            'opc_index_index'
        ];
        if (in_array($action, $arrCheckout) && in_array('checkout_page', $listDisableCode)) {
            return 404;
        }
        if ($action == 'catalogsearch_result_index' && in_array('search_page', $listDisableCode)) {
            return 404;
        }
        if ($action == 'catalog_product_view' && in_array('product_page', $listDisableCode)) {
            return 404;
        }
        if ($action == 'customer_account_create' && in_array('registration_page', $listDisableCode)) {
            return 404;
        }
        return $this->checkDisableMore2($action, $listDisableCode);
    }

    /**
     * @param string $action
     * @param array $listDisableCode
     * @return int
     */
    private function checkDisableMore2($action, $listDisableCode)
    {
        if (($action == 'catalogsearch_advanced_result'
            || $action == 'catalogsearch_advanced_index') && in_array('advanced_search_page', $listDisableCode)) {
            return 404;
        }
        if ($action == 'catalog_category_view' && in_array('category_page', $listDisableCode)) {
            return 404;
        }
        return 'pass';
    }
    /**
     * @return false|int|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProduct()
    {
        $productData = 404;
        $data   = $this->getFacebookPixelData();
        $action = $data['full_action_name'];
        if ($action == 'catalog_product_view' && $this->helper->isProductView()) {
            if ($this->getProductData() !== null) {
                $productData = $this->helper->serializes($this->getProductData());
            }
        }
        return $productData;
    }

    /**
     * @return false|int|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCategory()
    {
        $categoryData = 404;
        $data   = $this->getFacebookPixelData();
        $action = $data['full_action_name'];
        if ($action == 'catalog_category_view' && $this->helper->isCategoryView()) {
            if ($this->getCategoryData() !== null) {
                $categoryData = $this->helper->serializes($this->getCategoryData());
            }
        }
        return $categoryData;
    }

    /**
     * @return array|int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getOrder()
    {
        $orderData = 404;
        $data   = $this->getFacebookPixelData();
        $action = $data['full_action_name'];
        if ($action == 'checkout_onepage_success'
            || $action == 'onepagecheckout_index_success'
            || $action == 'multishipping_checkout_success') {
            $orderData = $this->getOrderData();
        }
        return $orderData;
    }

    /**
     * @return int|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getRegistration()
    {
        $session = $this->fbPixelSession->create();
        $registration = 404;
        if ($this->helper->isRegistration()
            && $session->hasRegister()) {
            $registration = $this->helper->getPixelHtml($session->getRegister());
        }
        return $registration;
    }

    /**
     * @return int|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getAddToWishList()
    {
        $session = $this->fbPixelSession->create();
        $add_to_wishlist = 404;
        if ($this->helper->isAddToWishList()
            && $session->hasAddToWishlist()) {
            $add_to_wishlist = $this->helper->getPixelHtml($session->getAddToWishlist());
        }
        return $add_to_wishlist;
    }

    /**
     * @return int|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getInitiateCheckout()
    {
        $session = $this->fbPixelSession->create();
        $initiateCheckout = 404;
        if ($this->helper->isInitiateCheckout()
            && $session->hasInitiateCheckout()) {
            $initiateCheckout = $this->helper->getPixelHtml($session->getInitiateCheckout());
        }
        return $initiateCheckout;
    }

    /**
     * @return int|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getSearch()
    {
        $session = $this->fbPixelSession->create();
        $search = 404;
        if ($this->helper->isSearch()
            && $session->hasSearch()) {
            $search = $this->helper->getPixelHtml($session->getSearch());
        }
        return $search;
    }

    /**
     * Returns data needed for purchase tracking.
     *
     * @return array|int
     */
    public function getOrderData()
    {
        $order = $this->checkoutSession->create()->getLastRealOrder();
        $orderId = $order->getIncrementId();

        if ($orderId && $this->helper->isPurchase()) {
            $customerEmail = $order->getCustomerEmail();
            if ($order->getShippingAddress()) {
                $addressData = $order->getShippingAddress();
            } else {
                $addressData = $order->getBillingAddress();
            }

            if ($addressData) {
                $customerData = $addressData->getData();
            } else {
                $customerData = null;
            }
            $product = [
                'content_ids' => [],
                'contents' => [],
                'value' => "",
                'currency' => "",
                'num_items' => 0,
                'email' => "",
                'address' => []
            ];

            $num_item = 0;
            foreach ($order->getAllVisibleItems() as $item) {
                $product['contents'][] = [
                    'id' => $item->getSku(),
                    'name' => $item->getName(),
                    'quantity' => (int)$item->getQtyOrdered(),
                    'item_price' => $item->getPrice()
                ];
                $product['content_ids'][] = $item->getSku();
                $num_item += round($item->getQtyOrdered());
            }
            $data = [
                'content_ids' => $product['content_ids'],
                'contents' => $product['contents'],
                'content_type' => 'product',
                'value' => number_format(
                    $order->getGrandTotal(),
                    2,
                    '.',
                    ''
                ),
                'num_items' => $num_item,
                'currency' => $order->getOrderCurrencyCode(),
                'email' => $customerEmail,
                'phone' => $this->getValueByKey($customerData, 'telephone'),
                'firtname' => $this->getValueByKey($customerData, 'firstname'),
                'lastname' => $this->getValueByKey($customerData, 'lastname'),
                'city' => $this->getValueByKey($customerData, 'city'),
                'country' => $this->getValueByKey($customerData, 'country_id'),
                'st' => $this->getValueByKey($customerData, 'region'),
                'zipcode' => $this->getValueByKey($customerData, 'postcode')
            ];
            return $this->helper->serializes($data);
        } else {
            return 404;
        }
    }

    /**
     * @param $array
     * @param $key
     * @return string
     */
    protected function getValueByKey($array, $key)
    {
        if (!empty($array) && isset($array[$key])) {
            return $array[$key];
        }
        return '';
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings(PHPMD.RequestAwareBlockMethod)
     */
    public function getFacebookPixelData()
    {
        $data = [];

        $data['id'] = $this->helper->returnPixelId();

        $data['full_action_name'] = $this->getRequest()->getFullActionName();

        return $data;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getProductData()
    {
        if (!$this->helper->isProductView()) {
            return [];
        }
        $currentProduct = $this->coreRegistry->registry('current_product');

        $data = [];

        $data['content_name']     = $this->helper
            ->escapeSingleQuotes($currentProduct->getName());
        $data['content_ids']      = $this->helper
            ->escapeSingleQuotes($currentProduct->getSku());
        $data['content_type']     = 'product';
        $data['value']            = $this->formatPrice(
            $this->helper->getProductPrice($currentProduct)
        );
        $data['currency']         = $this->helper->getCurrentCurrencyCode();

        return $data;
    }

    /**
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getCategoryData()
    {
        if (!$this->helper->isCategoryView()) {
            return [];
        }
        $currentCategory = $this->coreRegistry->registry('current_category');

        $data = [];

        $data['content_name']     = $this->helper
            ->escapeSingleQuotes($currentCategory->getName());
        $data['content_ids']      = $this->helper
            ->escapeSingleQuotes($currentCategory->getId());
        $data['content_type']     = 'category';
        $data['currency']         = $this->helper->getCurrentCurrencyCode();

        return $data;
    }

    /**
     * Returns formated price.
     *
     * @param string $price
     * @param string $currencyCode
     * @return string
     */
    private function formatPrice($price, $currencyCode = '')
    {
        $formatedPrice = number_format($price, 2, '.', '');

        if ($currencyCode) {
            return $formatedPrice . ' ' . $currencyCode;
        } else {
            return $formatedPrice;
        }
    }
}
