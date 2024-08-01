<?php

namespace Magexperts\WhatsappShareM2\Helper;
use Magento\Store\Model\ScopeInterface;
use Magento\Eav\Model\Config;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $scopeConfig;

    protected $_backendUrl;

    protected $_storeManager;
    
    protected $_urlInterface;
    
    public function __construct(

    \Magento\Framework\App\RequestInterface $httpRequest, 
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, 
    \Psr\Log\LoggerInterface $logger, 
    \Magento\Backend\Model\UrlInterface $backendUrl, 
    \Magento\Framework\UrlInterface $urlInterface, 
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    Config $eavConfig  
    )
    {
        $this ->scopeConfig = $scopeConfig;
        $this ->storeManager = $storeManager;
        $this->_backendUrl = $backendUrl;
        $this ->logger = $logger;
        $this->request = $httpRequest;
        $this->_eavConfig = $eavConfig;
        $this->_storeManager = $storeManager;
        $this->_urlInterface = $urlInterface;
       
     }
     
    public function isEnable()
    {
        return $this->scopeConfig->getValue('whatsappsharem2/general/status', 
        ScopeInterface::SCOPE_STORE);
    }
    public function getCurrentUrl()
    {
        return $this->_urlInterface->getCurrentUrl();
    }
    public function getDomain()
    {
        $domain =$this->request->getServer('SERVER_NAME');
        $temp = explode('.', $domain);
        $exceptions = array('co.uk', 'com.au', 'com.hk', 'co.nz', 'co.in', 'com.sg');
        $count = count($temp);
        if ($count === 1) 
        {
            return $domain;
        }
        $last = $temp[($count - 2)] . '.' . $temp[($count - 1)];
        if (in_array($last, $exceptions)) 
        {
            $new_domain = $temp[($count - 3)] . '.' . $temp[($count - 2)] . '.' . $temp[($count - 1)];
        } 
        else 
        {
            $new_domain = $temp[($count - 2)] . '.' . $temp[($count - 1)];
        }

        return $new_domain;
    }
    public function checkEntry($domain, $serial)
    {
        $key = sha1(base64_decode('TTJXaGF0c2FwcFNoYXJlTTI='));
        if (sha1($key . $domain) == $serial) 
        {
            return true;
        }
        return false;
    }

    public function canRun($temp = '')
    {
        
        $domain =$this->request->getServer('SERVER_NAME');
        if ($domain == "localhost" || $domain == "127.0.0.1") 
        {
            return true;
        }

        if ($temp == '') 
        {
            $temp = $this ->scopeConfig->getValue('whatsappsharem2/license_status_group/serial_key', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }
        $url = $this -> storeManager -> getStore() -> getBaseUrl();
        $parsedUrl = parse_url($url);
        $host = explode('.', $parsedUrl['host']);
        $subdomains = array_slice($host, 0, count($host) - 2);
        if (sizeof($subdomains) && ($subdomains[0] == 'test' || $subdomains[0] == 'demo' || $subdomains[0] == 'dev')) 
        {
            return true;
        }
        $original = $this -> checkEntry($this->request->getServer('SERVER_NAME'), $temp);
        $wildcard = $this -> checkEntry($this -> getDomain(), $temp);
        if (!$original && !$wildcard) 
        {
            return false;
        }
        return true;
    }
    
    public function getMessage()
    {
        return base64_decode('PGRpdj5MaWNlbnNlIG9mIDxiPk1pbG9wbGUgV2hhdHNhcHBTaGFyZU0yPC9iPiBleHRlbnNpb24gaGFzIGJlZW4gdmlvbGF0ZWQuIFRvIGdldCBzZXJpYWwga2V5IHBsZWFzZSBjb250YWN0IHVzIG9uIDxiPmh0dHBzOi8vd3d3Lm1pbG9wbGUuY29tL21hZ2VudG8tZXh0ZW5zaW9ucy9jb250YWN0cy88L2I+LjwvZGl2Pg==');
    }
    public function getAdminMessage()
    {
        return base64_decode('PGRpdj5MaWNlbnNlIG9mIDxiPk1pbG9wbGUgV2hhdHNhcHBTaGFyZU0yPC9iPiBleHRlbnNpb24gaGFzIGJlZW4gdmlvbGF0ZWQuIFRvIGdldCBzZXJpYWwga2V5IHBsZWFzZSBjb250YWN0IHVzIG9uIDxiPmh0dHBzOi8vd3d3Lm1pbG9wbGUuY29tL21hZ2VudG8tZXh0ZW5zaW9ucy9jb250YWN0cy88L2I+LjwvZGl2Pg==');
    }
    
    public function whatsappshare_size() {
        return $this->scopeConfig->getValue('whatsappsharem2/options/btnsize',ScopeInterface::SCOPE_STORE);
    }

    public function whatsappshare_text() {
        return $this->scopeConfig->getValue('whatsappsharem2/options/msg',
        ScopeInterface::SCOPE_STORE);
    }
}