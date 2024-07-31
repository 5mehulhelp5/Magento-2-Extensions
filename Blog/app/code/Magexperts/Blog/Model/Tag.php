<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Model;

use Magexperts\Blog\Model\Url;
use Magexperts\Blog\Api\ShortContentExtractorInterface;

/**
 * Tag model
 *
 * @method \Magexperts\Blog\Model\ResourceModel\Tag _getResource()
 * @method \Magexperts\Blog\Model\ResourceModel\Tag getResource()
 * @method string getTitle()
 * @method $this setTitle(string $value)
 * @method $this setIdentifier(string $value)
 */
class Tag extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    /**
     * Tag Status
     */
    const STATUS_ENABLED = 1;

    /**
     * blog cache tag
     */
    const CACHE_TAG = 'mfb_t';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'magexperts_blog_tag';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'blog_tag';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_url;

    /**
     * @var string
     */
    protected $controllerName;

    /**
     * @var ShortContentExtractorInterface
     */
    protected $shortContentExtractor;

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magexperts\Blog\Model\Url $url
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        Url $url,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->_url = $url;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Magexperts\Blog\Model\ResourceModel\Tag::class);
        $this->controllerName = URL::CONTROLLER_TAG;
    }

    /**
     * Retrieve true if tag is active
     * @return boolean
     */
    public function isActive()
    {
        return ($this->getIsActive() == self::STATUS_ENABLED);
    }

    /**
     * Retrieve if is visible on store
     * @return bool
     */
    public function isVisibleOnStore($storeId)
    {
        return $this->getIsActive()
            && (null === $storeId || array_intersect([0, $storeId], $this->getStoreIds()));
    }

    /**
     * Retrieve model title
     * @param  boolean $plural
     * @return string
     */
    public function getOwnTitle($plural = false)
    {
        return $plural ? 'Tags' : 'Tag';
    }

    /**
     * Check if tag identifier exist for specific store
     * return tag id if tag exists
     *
     * @param string $identifier
     * @param int $storeId
     * @return int
     */
    public function checkIdentifier($identifier, $storeId)
    {
        return $this->_getResource()->checkIdentifier($identifier, $storeId);
    }

    /**
     * Retrieve catgegory url route path
     * @return string
     */
    public function getUrl()
    {
        return $this->_url->getUrlPath($this, URL::CONTROLLER_TAG);
    }

    /**
     * Retrieve tag url
     * @return string
     */
    public function getTagUrl()
    {
        $url = $this->getData('tag_url');
        if (!$url) {
            $url = $this->_url->getUrl($this, URL::CONTROLLER_TAG);
            $this->setData('tag_url', $url);
        }

        return $url;
    }

    /**
     * Retrieve meta title
     * @return string
     */
    public function getMetaTitle()
    {
        $title = $this->getData('meta_title');
        if (!$title) {
            $title = $this->getData('title');
        }

        return trim($title ?: '');
    }

    /**
     * Retrieve meta description
     * @return string
     */
    public function getMetaDescription()
    {
        $desc = $this->getData('meta_description');
        if (!$desc) {
            $desc = $this->getShortContentExtractor()->execute($this->getData('content'), 200);
        }

        $stylePattern = "~\<style(.*)\>(.*)\<\/style\>~";
        $desc = preg_replace($stylePattern, '', $desc);
        $desc = trim(strip_tags((string)$desc));

        if (mb_strlen($desc) > 200) {
            $desc = mb_substr($desc, 0, 200);
        }

        return trim($desc);
    }

    /**
     * Retrieve identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Retrieve block identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return (string)$this->getData('identifier');
    }

    /**
     * Retrieve controller name
     * @return string
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @deprecated use getDynamicData method in graphQL data provider
     * Return all additional data
     * @return array
     */
    public function getDynamicData()
    {
        $data = $this->getData();

        $keys = [
            'meta_description',
            'meta_title',
            'tag_url',
        ];

        foreach ($keys as $key) {
            $method = 'get' . str_replace(
                '_',
                '',
                ucwords($key, '_')
            );
            $data[$key] = $this->$method();
        }

        return $data;
    }

    /**
     * @return ShortContentExtractorInterface
     */
    public function getShortContentExtractor()
    {
        if (null === $this->shortContentExtractor) {
            $this->shortContentExtractor = \Magento\Framework\App\ObjectManager::getInstance()
                ->get(ShortContentExtractorInterface::class);
        }

        return $this->shortContentExtractor;
    }
}
