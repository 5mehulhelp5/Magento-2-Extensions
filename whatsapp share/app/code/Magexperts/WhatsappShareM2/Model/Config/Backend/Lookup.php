<?php

namespace Magexperts\WhatsappShareM2\Model\Config\Backend;

class Lookup extends \Magento\Framework\App\Config\Value
{
    protected $directoryHelper;

    protected $_storeManager;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Helper\Data $directoryHelper,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magexperts\WhatsappShareM2\Helper\Data $data_helper,
        array $data = []
    ) 
    {
        $this->directoryHelper = $directoryHelper;
        $this->helper = $data_helper;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
        $this->_storeManager = $storeManager;
    }
    public function beforeSave()
    {
        $value = (string)$this->getValue();
        if (!$this->helper->canRun($this->getValue())) 
        {
            $massage = $this->helper->getAdminMessage();
            throw new \Magento\Framework\Exception\LocalizedException(__($massage));
        }
    }
}
