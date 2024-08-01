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

use \AllowDynamicProperties;
#[AllowDynamicProperties]
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\Currency $currency
    )
    {

        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->currency = $currency;
    }

    public function getCurrencySymbol()
    {
        return $this->currency->getCurrencySymbol();
    }

    public function getCurrencyCode()
    {
        return $this->currency->getCurrencyCode();
    }

    public function getDomain()
    {
        $domain = $this->getDomainName($this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB));
        $temp = explode('.', $domain);
        $exceptions = array('co.uk', 'com.au', 'com.hk', 'co.nz', 'co.in', 'com.sg');
        $count = count($temp);
        if ($count === 1) {
            return $domain;
        }
        $last = $temp[($count - 2)] . '.' . $temp[($count - 1)];
        if (in_array($last, $exceptions)) {
            $new_domain = $temp[($count - 3)] . '.' . $temp[($count - 2)] . '.' . $temp[($count - 1)];
        } else {
            $new_domain = $temp[($count - 2)] . '.' . $temp[($count - 1)];
        }

        return $new_domain;
    }

    function getDomainName($url)
    {
        $custom_domain = preg_replace('#^https?://#', '', $url);
        $matchFound = preg_match('@^(?:http://)?([^/]+)@i', $custom_domain, $matches);
        if ($matchFound) {
            $custom_domain = $matches[1];
        }
        $cmpstr = substr($custom_domain, 0, 4);
        if ($cmpstr == "www.") {
            $custom_domain = str_replace('www.', "", $custom_domain);
        }
        return strtolower($custom_domain);
    }

    public function checkEntry($domain, $serial)
    {
        $key = sha1(base64_decode('TTJQYXJ0aWFsUGF5bWVudEF1dG8='));
        if (sha1($key . $domain) == $serial) {
            return true;
        }
        return false;
    }

    public function canRun($temp = '')
    {

        if ($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "127.0.0.1") {
            return true;
        }

        if ($temp == '') {
            $temp = $this->scopeConfig->getValue('infinitescroll/license/infinitescroll_serialkey', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }

        $url = $this->storeManager->getStore()->getBaseUrl();
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['host']);
        $subdomains = array_slice($host, 0, count($host) - 2);
        if (sizeof($subdomains) && ($subdomains[0] == 'test' || $subdomains[0] == 'demo' || $subdomains[0] == 'dev')) {
            return true;
        }
        $original = $this->checkEntry($_SERVER['SERVER_NAME'], $temp);
        $wildcard = $this->checkEntry($this->getDomain(), $temp);
        if (!$original && !$wildcard) {
            return false;
        }
        return true;
    }

    public function getAdminMessage()
    {
        return base64_decode('PGRpdj5MaWNlbnNlIG9mIDxiIHN0eWxlPSJmb250LXdlaWdodDogYm9sZGVyICFpbXBvcnRhbnQ7Ij5NaWxvcGxlIEluZmluaXRlU2Nyb2xsPC9iPiBleHRlbnNpb24gaGFzIGJlZW4gdmlvbGF0ZWQuIFRvIGdldCBzZXJpYWwga2V5IHBsZWFzZSBjb250YWN0IHVzIG9uIDxiIHN0eWxlPSJmb250LXdlaWdodDogYm9sZGVyICFpbXBvcnRhbnQ7Ij5odHRwczovL3d3dy5taWxvcGxlLmNvbS9tYWdlbnRvLWV4dGVuc2lvbnMvY29udGFjdHMvPC9iPjwvZGl2Pg==');
    }
}