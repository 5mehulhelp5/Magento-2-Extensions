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
 * @package   Magexperts_Limitcartqty
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\Limitcartqty\Helper;

use Magento\Customer\Api\GroupManagementInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Math\Random;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class ConfigValue
 *
 * @package Magexperts\Limitcartqty\Helper
 */
class ConfigValue
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var Random
     */
    protected $mathRandom;
    /**
     * @var GroupManagementInterface
     */
    protected $groupManagement;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * ConfigValue constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param Random $mathRandom
     * @param GroupManagementInterface $groupManagement
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Random $mathRandom,
        GroupManagementInterface $groupManagement,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->mathRandom = $mathRandom;
        $this->groupManagement = $groupManagement;
        $this->storeManager = $storeManager;
    }

    /**
     * Get Store Id
     *
     * @return int
     * @throws NoSuchEntityException
     */
    public function getStoreId()
    {
        return $this->storeId = $this->storeManager->getStore()->getId();
    }

    /**
     * Fix Qty
     *
     * @param int $qty
     * @return float|null
     */
    protected function fixQty($qty)
    {
        return !empty($qty) ? (float) $qty : null;
    }

    /**
     * SerializeValue
     *
     * @param float $value
     * @return string
     * @throws LocalizedException
     */
    protected function serializeValue($value)
    {
        if (is_numeric($value)) {
            $data = (float) $value;
            return (string) $data;
        } elseif (is_array($value)) {
            $data = [];
            foreach ($value as $groupId => $qty) {
                if (!array_key_exists($groupId, $data)) {
                    $data[$groupId] = $this->fixQty($qty);
                }
            }
            if (count($data) == 1 && array_key_exists($this->getAllCustomersGroupId(), $data)) {
                return (string) $data[$this->getAllCustomersGroupId()];
            }
            return serialize($data);
        } else {
            return '';
        }
    }

    /**
     * Value
     *
     * @param number $value
     * @return array|mixed
     * @throws LocalizedException
     */
    protected function unserializeValue($value)
    {
        if (is_numeric($value)) {
            return [$this->getAllCustomersGroupId() => $this->fixQty($value)];
        } elseif (is_string($value) && !empty($value)) {
            return unserialize($value);
        } else {
            return [];
        }
    }

    /**
     * Value
     *
     * @param array $value
     * @return bool
     */
    protected function isEncodedArrayFieldValue($value)
    {
        if (!is_array($value)) {
            return false;
        }
        unset($value['__empty']);
        foreach ($value as $row) {
            if (!is_array($row)
                || !array_key_exists('customer_group_id', $row)
                || !array_key_exists('config_value', $row)
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * Value
     *
     * @param array $value
     * @return array
     * @throws LocalizedException
     */
    protected function encodeArrayFieldValue(array $value)
    {
        $result = [];
        foreach ($value as $groupId => $qty) {
            $resultId = $this->mathRandom->getUniqueHash('_');
            $result[$resultId] = ['customer_group_id' => $groupId, 'config_value' => $this->fixQty($qty)];
        }
        return $result;
    }

    /**
     * Value
     *
     * @param array $value
     * @return array
     */
    protected function decodeArrayFieldValue(array $value)
    {
        $result = [];
        unset($value['__empty']);
        foreach ($value as $row) {
            if (!is_array($row)
                || !array_key_exists('customer_group_id', $row)
                || !array_key_exists('config_value', $row)
            ) {
                continue;
            }
            $groupId = $row['customer_group_id'];
            $qty = $this->fixQty($row['config_value']);
            $result[$groupId] = $qty;
        }
        return $result;
    }

    /**
     * Get Min
     *
     * @param int $_customerGroupId
     * @return float|null
     * @throws LocalizedException
     */
    public function getMinConfigValue($_customerGroupId)
    {
        $value = $this->scopeConfig->getValue(
            'Magexperts_Commerce/item_options/Magexperts_min_total_qty',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );
        $value = $this->unserializeValue($value);
        if ($this->isEncodedArrayFieldValue($value)) {
            $value = $this->decodeArrayFieldValue($value);
        }
        $result = null;
        foreach ($value as $groupId => $qty) {
            if ($groupId == $_customerGroupId) {
                $result = $qty;
                break;
            } elseif ($groupId == $this->getAllCustomersGroupId()) {
                $result = $qty;
            }
        }
        return $this->fixQty($result);
    }

    /**
     * Get Max
     *
     * @param int $_customerGroupId
     * @return float|null
     * @throws LocalizedException
     */
    public function getMaxConfigValue($_customerGroupId)
    {
        $value = $this->scopeConfig->getValue(
            'Magexperts_Commerce/item_options/Magexperts_max_total_qty',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );
        $value = $this->unserializeValue($value);
        if ($this->isEncodedArrayFieldValue($value)) {
            $value = $this->decodeArrayFieldValue($value);
        }
        $result = null;
        foreach ($value as $groupId => $qty) {
            if ($groupId == $_customerGroupId) {
                $result = $qty;
                break;
            } elseif ($groupId == $this->getAllCustomersGroupId()) {
                $result = $qty;
            }
        }
        return $this->fixQty($result);
    }

    /**
     * Check Enable
     *
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function isModuleEnable()
    {
        return $this->scopeConfig->getValue(
            'Magexperts_Commerce/Limitcartqty/Enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );
    }

    /**
     * Value
     *
     * @param string $value
     * @return array|mixed
     * @throws LocalizedException
     */
    public function makeArrayFieldValue($value)
    {
        $value = $this->unserializeValue($value);
        if (!$this->isEncodedArrayFieldValue($value)) {
            $value = $this->encodeArrayFieldValue($value);
        }
        return $value;
    }

    /**
     * Value
     *
     * @param array $value
     * @return array|string
     * @throws LocalizedException
     */
    public function makeStorableArrayFieldValue($value)
    {
        if ($this->isEncodedArrayFieldValue($value)) {
            $value = $this->decodeArrayFieldValue($value);
        }
        $value = $this->serializeValue($value);
        return $value;
    }

    /**
     * Validate Qty before save config
     *
     * @param array|string $value
     * @return bool
     */
    public function validateMinMaxQty($value)
    {
        unset($value['__empty']);
        if ($this->isEncodedArrayFieldValue($value)) {
            foreach ($value as $row) {
                if (!ctype_digit(strval($row['config_value'])) || $row['config_value'] <= 0) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get Customer Id
     *
     * @return int|null
     * @throws LocalizedException
     */
    protected function getAllCustomersGroupId()
    {
        return $this->groupManagement->getAllCustomersGroup()->getId();
    }
}
