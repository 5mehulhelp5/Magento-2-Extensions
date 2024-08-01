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
namespace Magexperts\InfiniteScroll\Model\Config\Backend;

/**
 * Class Validate
 * @package Magexperts\InfiniteScroll\Model\Config\Backend
 */
class Validate extends \Magento\Framework\App\Config\Value
{
    /**
     * @var \Magento\Directory\Helper\Data
     */
    protected $directoryHelper;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Directory\Helper\Data $directoryHelper
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Helper\Data $directoryHelper,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magexperts\InfiniteScroll\Helper\Data $data_helper,
        array $data = []
    ) {
        $this->directoryHelper = $directoryHelper;
        $this->helper = $data_helper;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->_storeManager = $storeManager;
    }

    /**
     * @return $this|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeSave()
    {
        $value = (string)$this->getValue();
        if( !$this->helper->canRun($this->getValue()) ){
            $massage = $this->helper->getAdminMessage();
            throw new \Magento\Framework\Exception\LocalizedException(__($massage));
        }
    }
}
