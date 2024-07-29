<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_MicrosoftClarity
 */

/**
 * Copyright © Magexperts. All rights reserved.
 */
declare(strict_types=1);

namespace Magexperts\MicrosoftClarity\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\ResourceModel\GroupRepository as CustomerGroupRepository;

class Script extends Template
{
    /**
     * Feature enabled config path
     */
    const XML_MICROSOFT_CLARITY_GENERAL_ENABLE = 'microsoft_clarity/general/enable';
    /**
     * Customer group
     */
    const XML_MICROSOFT_CLARITY_CUSTOMER_GROUP_TAG_ENABLE = 'microsoft_clarity/general/customer_group_tag_enable';
    /**
     * Tracking code config path
     */
    const XML_MICROSOFT_CLARITY_OPTIONS_TRACKING_CODE = 'microsoft_clarity/options/tracking_code';
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * @var CustomerGroupRepository
     */
    private $customerGroupRepository;

    /**
     * Script constructor.
     *
     * @param Template\Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param CustomerSession $customerSession
     * @param CustomerGroupRepository $customerGroupRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        CustomerSession $customerSession,
        CustomerGroupRepository $customerGroupRepository,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->customerGroupRepository = $customerGroupRepository;
    }

    /**
     * Returns the Clarity tracking code to be used in the javascript
     *
     * @return string
     */
    public function getClarityTrackingCode()
    {
        return $this->scopeConfig->getValue(
            self::XML_MICROSOFT_CLARITY_OPTIONS_TRACKING_CODE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Checks if feature is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_MICROSOFT_CLARITY_GENERAL_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Checks if customer group tag to be added
     *
     * @return bool
     */
    public function isCustomerGroupTagEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_MICROSOFT_CLARITY_CUSTOMER_GROUP_TAG_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCustomerGroup()
    {
        $customerGroupId = $this->customerSession->getCustomerGroupId();
        $customerGroup = $this->customerGroupRepository->getById($customerGroupId);

        return $customerGroup->getCode();
    }
}
