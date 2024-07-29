<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Email\Model\Template\SenderResolver;
use Magento\Framework\App\ProductMetadataInterface;
use Magexperts\Smtp\Controller\RegistryConstants;

/**
 * Class Config
 * @package Magexperts\Smtp\Model
 */
class Config
{
    /**
     * Constants
     */
    const MODULE_NAME = 'aitsmtp';
    const XML_PATH_TEMPLATE_ENABLED = 'aitsmtp/general/enabled';
    const XML_PATH_TEMPLATE_SMTP = 'aitsmtp/smtp/';
    const XML_PATH_TEMPLATE_EMAILS = 'aitsmtp/emails/';
    const XML_PATH_TEMPLATE_DEBUG = 'aitsmtp/debug/';
    const XML_PATH_TEMPLATE_LOG = 'aitsmtp/log/';

    const ENCRYPTED_PASSWORD_VALUE = '******';

    /**
     * @var \Magexperts\Core\Helper\Config
     */
    private $config;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Config\Options\Protocol
     */
    private $protocol;

    /**
     * @var Config\Options\Auth
     */
    private $auth;

    /**
     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    private $encryptor;

    /**
     * @var SenderResolver
     */
    private $senderResolver;

    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    /**
     * @var array
     */
    private $smtpFields = [
        'name', 'host', 'port', 'protocol', 'login', 'password', 'auth_type'
    ];

    public function __construct(
        \Magexperts\Core\Helper\Config $config,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magexperts\Smtp\Model\Config\Options\Protocol $protocol,
        \Magexperts\Smtp\Model\Config\Options\Auth $auth,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor,
        SenderResolver $senderResolver,
        ProductMetadataInterface $productMetadata
    ) {
        $this->config = $config;
        $this->request = $request;
        $this->protocol = $protocol;
        $this->storeManager = $storeManager;
        $this->auth = $auth;
        $this->encryptor = $encryptor;
        $this->senderResolver = $senderResolver;
        $this->productMetadata = $productMetadata;
    }

    /**
     * @return bool
     */
    public function enabled()
    {
        return  (bool)$this->config->getModuleConfig(self::XML_PATH_TEMPLATE_ENABLED, $this->getCurrentStoreId());
    }

    /**
     * @return int|mixed
     */
    public function getCurrentStoreId()
    {
        $storeId = 0;
        $requestStore = $this->request->getParam(ScopeInterface::SCOPE_STORE);
        $requestWebsite = $this->request->getParam(ScopeInterface::SCOPE_WEBSITE);

        try {
            if ($requestStore) {
                $storeId = $requestStore;
            } elseif ($requestWebsite) {
                $storeId = $this->storeManager->getWebsite($requestWebsite)->getDefaultStore()->getId();
            } else {
                $storeId = $this->storeManager->getStore()->getId();
            }
        } catch (LocalizedException $exception) {
        } catch (NoSuchEntityException $e) {
        }

        return $storeId;
    }

    /**
     * @return array
     */
    public function getCcEmails()
    {
        $allowedEmailsString = $this->config->getModuleConfig(
            self::XML_PATH_TEMPLATE_EMAILS . 'cc',
            $this->getCurrentStoreId()
        );

        return $this->getDataFromString($allowedEmailsString);;
    }

    /**
     * @return array|bool
     */
    public function getBccEmails()
    {
        $allowedEmailsString = $this->config->getModuleConfig(
            self::XML_PATH_TEMPLATE_EMAILS . 'bcc',
            $this->getCurrentStoreId()
        );

        return $this->getDataFromString($allowedEmailsString);
    }

    /**
     * @return array|bool
     */
    protected function _getExceptionalEmails()
    {
        $allowedEmailsString = $this->config->getModuleConfig(
            self::XML_PATH_TEMPLATE_DEBUG . 'exeptional_email_addresses',
            $this->getCurrentStoreId()
        );

        $arrayFromString = explode(',', $allowedEmailsString);
        array_walk($arrayFromString, [$this, 'trimAllowedValues']);


        return $arrayFromString;
    }

    /**
     * @return array|bool
     */
    protected function _getExceptionalDomains()
    {
        $allowedDomainsString = $this->config->getModuleConfig(
            self::XML_PATH_TEMPLATE_DEBUG . 'exeptional_domains',
            $this->getCurrentStoreId()
        );

        $arrayFromString = explode(',', $allowedDomainsString);
        array_walk($arrayFromString, [$this, 'trimAllowedValues']);

        return $arrayFromString;
    }

    /**
     * @param $string
     * @return array|bool
     */
    private function getDataFromString($string)
    {
        if ($string) {
            $result = [];
            $arrayFromString = explode(',', $string);
            array_walk($arrayFromString, [$this, 'trimAllowedValues']);

            foreach ($arrayFromString as $item) {
                $result[] = [
                    'email' => $item,
                    'name' => null
                ];
            }

            return $result;
        }
        return false;
    }

    /**
     * @param $allowedValuesArray
     */
    public function trimAllowedValues(&$allowedValuesArray)
    {
        $allowedValuesArray = trim($allowedValuesArray);
    }

    /**
     * @param $email
     * @return bool
     */
    public function needToBlockEmail($email)
    {
        if ($this->config->getModuleConfig(
            self::XML_PATH_TEMPLATE_DEBUG . 'delivery',
            $this->getCurrentStoreId()
        )) {
            $domains = $this->_getExceptionalDomains();
            $emails = $this->_getExceptionalEmails();

            if (($emails && in_array($email, $emails)) || (is_array($domains) && $this->validDomain($email, $domains)))
            {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @param $postParams
     * @return array
     */
    public function convertFromPostToSmtpParams($postParams)
    {
        $result = [];

        foreach ($postParams as $key => $item) {
            switch ($key) {
                case 'protocol':
                    $key = 'ssl';
                    $item = $this->protocol->getOptionById($item);
                    break;
                case 'auth_type':
                    $key = 'auth';
                    $item = $this->auth->getOptionById($item);
                    break;
                case 'login':
                    $key = 'username';
                    break;
                case 'password':
                    if ($item == self::ENCRYPTED_PASSWORD_VALUE) {
                        $configValue = $this->config->getModuleConfig(
                            self::XML_PATH_TEMPLATE_SMTP . 'password',
                            $this->getCurrentStoreId()
                        );

                        $item = $this->encryptor->decrypt($configValue);
                    }

                    break;
                default:
                    break;
            }

            $result[$key] = $item;
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isBlockedDelivery()
    {
        return  (bool)$this->config->getModuleConfig(
            self::XML_PATH_TEMPLATE_DEBUG . 'delivery',
            $this->getCurrentStoreId()
        );
    }

    /**
     * @return bool
     */
    public function logEnabled()
    {
        return  (bool)$this->config->getModuleConfig(self::XML_PATH_TEMPLATE_LOG . 'log', $this->getCurrentStoreId());
    }

    /**
     * @return bool
     */
    public function plainEnabled()
    {
        return  (bool)$this->config->getModuleConfig(self::XML_PATH_TEMPLATE_EMAILS . 'plain', $this->getCurrentStoreId());
    }

    /**
     * @return int
     */
    public function cleanLogDays()
    {
        return  (int)$this->config->getModuleConfig(
            self::XML_PATH_TEMPLATE_LOG . 'log_clean',
            $this->getCurrentStoreId()
        );
    }

    /**
     * @param $message
     * @param bool $isTest
     * @return mixed
     */
    public function prepareMessageToSend($message, $isTest = false)
    {
        $senderData = $this->getAnotherEmailSenderData();

        if (!$senderData && $isTest) {
            $senderData = $this->getSenderData();
        }

        if ($senderData) {
            $message->setFrom($this->getNewAddress($senderData));
        }

        if (!$isTest) {
            $ccEmails = $this->getCcEmails();
            $bccEmails = $this->getBccEmails();

            if ($ccEmails) {
                $message->addCc($this->getAddressList($ccEmails));
            }

            if ($bccEmails) {
                $message->addBcc($this->getAddressList($bccEmails));
            }
        }

        return $message;
    }

    /**
     * @param $emailData
     * @return \Zend\Mail\Address
     */
    public function getNewAddress($emailData){
        return new \Zend\Mail\Address($emailData['email'], $emailData['name']);
    }


    /**
     * @param $emailsData
     * @return \Zend\Mail\AddressList
     */
    public function getAddressList($emailsData) {
        $addressList = new \Zend\Mail\AddressList();

        foreach ($emailsData as $data) {
            $addressList->add($data['email'], isset($data['name']) ? $data['name'] : null);
        }

        return $addressList;
    }

    /**
     * @param string $type
     * @return array|string
     * @throws \Magento\Framework\Exception\MailException
     */
    public function getSenderData($type = 'general')
    {
        return $this->senderResolver->resolve($type, $this->getCurrentStoreId());
    }

    /**
     * @param $email
     * @param $domains
     * @return bool
     */
    protected function validDomain($email, $domains)
    {
        $regExp = '/^(http:\/\/|https:\/\/){0,1}(www\.){0,1}([0-9a-z_\-\.]*[0-9a-z]*\.[a-z]{2,5})$/iu';

        $emailDomain = substr(strrchr($email, "@"), 1);

        foreach ($domains as $domain) {
            if (preg_match($regExp, $domain, $parts) && $emailDomain == $parts[3]) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getAnotherEmailSenderData()
    {
        $result = [];

        if ($this->config->getModuleConfig(
            self::XML_PATH_TEMPLATE_EMAILS . 'sender_enable',
            $this->getCurrentStoreId()
        )) {
            $senderEmail = $this->config->getModuleConfig(
                self::XML_PATH_TEMPLATE_EMAILS . 'sender_email',
                $this->getCurrentStoreId()
            );

            $senderName = $this->config->getModuleConfig(
                self::XML_PATH_TEMPLATE_EMAILS . 'sender_name',
                $this->getCurrentStoreId()
            );

            if ($senderEmail) {
                $senderName = $senderName ?: null;

                $result = [
                    'name' => $senderName,
                    'email' => $senderEmail
                ];
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getFullConfig()
    {
        $result = [];

        foreach ($this->smtpFields as $field) {
            $configValue = $this->config->getModuleConfig(
                self::XML_PATH_TEMPLATE_SMTP . $field,
                $this->getCurrentStoreId()
            );

            if ($configValue === null) {
                continue;
            }

            if ($field == 'protocol') {
                if (!$configValue) {
                    continue;
                }
                $field = 'ssl';
                $configValue = $this->protocol->getOptionById($configValue);
            }

            if ($field == 'login') {
                $field = 'username';
            }

            if ($field == 'password') {
                $configValue = $this->encryptor->decrypt($configValue);
            }

            if ($field == 'auth_type') {
                $field = 'auth';
                $configValue = $this->auth->getOptionById($configValue);
            }

            $result[$field] = $configValue;
        }

        return $result;
    }

    /**
     * @param $version
     * @return mixed
     */
    public function isNewSender($version)
    {
        $currentVersion = $this->productMetadata->getVersion();

        return version_compare($currentVersion, $version, '>=');
    }
}
