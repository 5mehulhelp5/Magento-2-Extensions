<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\AutoRelatedProduct\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Config
 * @package Magexperts\AutoRelatedProduct\Model
 */
class Config implements \Magexperts\AutoRelatedProduct\Api\ConfigInterface
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Extension enabled config path
     */
    const XML_PATH_EXTENSION_ENABLED = 'autorp/general/enabled';

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Retrieve true if module is enabled
     *
     * @return bool
     */
    public function isEnabled($storeId = null): bool
    {
        return (bool)$this->getConfig(self::XML_PATH_EXTENSION_ENABLED, $storeId);
    }

    /**
     * Retrieve store config value
     * @param string $path
     * @param null $storeId
     * @return mixed
     */
    public function getConfig($path, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
