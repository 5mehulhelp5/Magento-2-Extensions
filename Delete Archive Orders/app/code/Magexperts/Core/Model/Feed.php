<?php

namespace Magexperts\Core\Model;

use Magento\Framework\Config\ConfigOptionsListConstants;
use Magento\Framework\Notification\MessageInterface;

/**
 * AdminNotification Feed model
 */
class Feed extends \Magento\AdminNotification\Model\Feed
{
    const AITOC_CACHE_NAME = 'magexperts_notifications_lastcheck';
    const XML_USE_HTTPS_PATH = 'system/adminnotification/use_https';

    const XML_FEED_URL_PATH = 'www.magexperts.com/feedrss';

    const XML_FREQUENCY_PATH = 'system/adminnotification/frequency';

    const XML_LAST_UPDATE_PATH = 'system/adminnotification/last_update';

    /**
     * Feed url
     *
     * @var string
     */
    protected $_feedUrl;

    /**
     * @var \Magento\Backend\App\ConfigInterface
     */
    protected $_backendConfig;

    /**
     * @var \Magento\AdminNotification\Model\InboxFactory
     */
    protected $_inboxFactory;

    /**
     * @var \Magento\Framework\HTTP\Adapter\CurlFactory
     *
     */
    protected $curlFactory;

    /**
     * Deployment configuration
     *
     * @var \Magento\Framework\App\DeploymentConfig
     */
    protected $_deploymentConfig;

    /**
     * @var \Magento\Framework\App\ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magexperts\Core\Helper\Notice
     */
    private $noticeHelper;

    /**
     * @var \Magexperts\Core\Helper\Extension
     */
    private $extensionHelper;

    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    private $configWriter;

    /**
     * @var \Magento\Backend\App\ConfigInterface
     */
    private $config;

    /**
     * @var \Magento\Framework\App\Config\ReinitableConfigInterface
     */
    private $reinitableConfig;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Backend\App\ConfigInterface $backendConfig
     * @param InboxFactory $inboxFactory
     * @param \Magento\Framework\HTTP\Adapter\CurlFactory $curlFactory
     * @param \Magento\Framework\App\DeploymentConfig $deploymentConfig
     * @param \Magento\Framework\App\ProductMetadataInterface $productMetadata
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Backend\App\ConfigInterface $backendConfig,
        \Magento\AdminNotification\Model\InboxFactory $inboxFactory,
        \Magento\Framework\HTTP\Adapter\CurlFactory $curlFactory,
        \Magento\Framework\App\DeploymentConfig $deploymentConfig,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magexperts\Core\Helper\Notice $noticeHelper,
        \Magexperts\Core\Helper\Extensions $extensionHelper,
        \Magento\Backend\App\ConfigInterface $config,
        \Magento\Framework\App\Config\ReinitableConfigInterface $reinitableConfig,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $backendConfig,
            $inboxFactory,
            $curlFactory,
            $deploymentConfig,
            $productMetadata,
            $urlBuilder,
            $resource,
            $resourceCollection,
            $data
        );
        $this->noticeHelper = $noticeHelper;
        $this->extensionHelper = $extensionHelper;
        $this->config = $config;
        $this->configWriter = $configWriter;
        $this->reinitableConfig = $reinitableConfig;
    }

    /**
     * Init model
     *
     * @return void
     */
    protected function _construct()
    {
    }

    /**
     * Retrieve feed url
     *
     * @return string
     */
    public function getFeedUrl()
    {
        $httpPath = $this->_backendConfig->isSetFlag(self::XML_USE_HTTPS_PATH) ? 'https://' : 'http://';
        if ($this->_feedUrl === null) {
            $this->_feedUrl = $httpPath . self::XML_FEED_URL_PATH;
        }
        return $this->_feedUrl;
    }

    /**
     * Check feed for modification
     *
     * @return $this
     */
    public function checkUpdate()
    {
        if ($this->getFrequency() + $this->getLastUpdate() > time()) {
            return $this;
        }

        if (!$this->noticeHelper->isEnable()) {
            return $this;
        }

        $feedData = [];

        $feedXml = $this->getFeedData();

        $installDate = $this->getFirstMagexpertsRun();

        if ($feedXml && $feedXml->channel && $feedXml->channel->item) {
            foreach ($feedXml->channel->item as $item) {
                $pubDate = strtotime((string)$item->pubDate);
                $itemPublicationDate = strtotime((string)$item->pubDate);

                if ($itemPublicationDate <= $installDate || !$this->isInteresting($item)) {
                    continue;
                }

                $feedData[] = [
                    'severity' => MessageInterface::SEVERITY_NOTICE,
                    'date_added' => date('Y-m-d H:i:s', $pubDate),
                    'title' => $this->escapeString($item->title),
                    'description' => $this->escapeString($item->description),
                    'url' => $this->escapeString($item->link),
                    'magexperts_notification' => 1
                ];
            }

            if ($feedData) {
                $this->_inboxFactory->create()->parse(array_reverse($feedData));
            }
        }
        $this->setLastUpdate();

        return $this;
    }

    /**
     * @return int|mixed
     */
    private function getFirstMagexpertsRun()
    {
        $coreConfigRunPath = 'magexperts_core/notifications/first_magexperts_run';
        $result = $this->config->getValue($coreConfigRunPath);
        if (!$result) {
            $result = time();
            $this->configWriter->save($coreConfigRunPath, $result);
            $this->reinitableConfig->reinit();
        }

        return $result;
    }


    /**
     * @param $item
     * @return bool
     */
    private function isInteresting($item)
    {
        $interests = $this->getTypes();

        if (!$interests) {
            return false;
        }

        if ($item->type != \Magexperts\Core\Model\Config\Source\NoticeType::EXTENSION_UPDATE
            && in_array((string)$item->type, $interests)
        ) {
            return true;
        }

        if ($item->type == \Magexperts\Core\Model\Config\Source\NoticeType::EXTENSION_UPDATE
            && in_array(\Magexperts\Core\Model\Config\Source\NoticeType::EXTENSION_UPDATE_CUSTOMER, $interests)
            && !in_array(\Magexperts\Core\Model\Config\Source\NoticeType::EXTENSION_UPDATE, $interests)
        ) {
            $extData = explode('-', (string)$item->extension);

            if (!$extData) {
                return false;
            }

            $extension = $extData[0];

            if (array_key_exists(1, $extData)) {
                $platform = $extData[1];
            }

            $isMagentoEE = $this->extensionHelper->getMagentoEdition() != 'Community';
            if ($isMagentoEE && $platform == 'EE'
                || !$isMagentoEE && empty($platform)
            ) {
                return $this->extensionHelper->isModuleEnabled($extension);
            }
        }

        return false;
    }

    /**
     * @return array
     */
    private function getTypes()
    {
        return $this->noticeHelper->getNotificationTypes();
    }

    /**
     * Retrieve Update Frequency
     *
     * @return int
     */
    public function getFrequency()
    {
        return (int)$this->noticeHelper->getFrequency() * 60 * 60 * 24;
    }

    /**
     * Retrieve Last update time
     *
     * @return int
     */
    public function getLastUpdate()
    {
        return $this->_cacheManager->load(self::AITOC_CACHE_NAME);
    }

    /**
     * Set last update time (now)
     *
     * @return $this
     */
    public function setLastUpdate()
    {
        $this->_cacheManager->save(time(), self::AITOC_CACHE_NAME);
        return $this;
    }

    /**
     * Converts incoming data to string format and escapes special characters.
     *
     * @param \SimpleXMLElement $data
     * @return string
     */
    private function escapeString(\SimpleXMLElement $data)
    {
        return htmlspecialchars((string)$data);
    }
}
