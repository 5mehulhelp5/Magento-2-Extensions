<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_TwoFactorAuthentication
 */

/**
 * Copyright © 2016 Magexperts. All rights reserved.
 */
namespace Magexperts\TwoFactorAuthentication\Model;

use Magexperts\TwoFactorAuthentication\Api\Data\UserInterface;

class User extends \Magento\Framework\Model\AbstractModel implements UserInterface
{
    /**
     * @var string
     */
    const SHOW_IP_FIELD  = 'current_ip';
    
    /**
     * @var string
     */
    const SHOW_TFA_FIELD = 'tfa_key';
    
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magexperts\TwoFactorAuthentication\Model\ResourceModel\User');
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::USER_ID);
    }

    /**
     * Get Original User Id
     *
     * @return int|null
     */
    public function getOriginalId()
    {
        return $this->getData(self::ORIGINAL_USER_ID);
    }

    /**
     * Get Secret
     *
     * @return string
     */
    public function getUserSecret()
    {
        return $this->getData(self::USER_SECRET);
    }

    /**
     * Get Time Shift
     *
     * @return int|null
     */
    public function getTimeShift()
    {
        return $this->getData(self::TIME_SHIFT);
    }
    
    /**
     * Get Is Active
     *
     * @return int|null
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }
    
    /**
     * Get IP Enabled
     *
     * @return int|null
     */
    public function getIpEnabled()
    {
        return $this->getData(self::IP_ENABLED);
    }
    
    /**
     * Get IP List
     *
     * @return string|null
     */
    public function getIpList()
    {
        return $this->getData(self::IP_LIST);
    }
    
    /**
     * Get Email Enabled
     *
     * @return int
     */
    public function getEmailCodeEnabled()
    {
        return $this->getData(self::EMAIL_CODE_ENABLED);
    }
    
    /**
     * Set ID
     *
     * @return RoleInterface
     */
    public function setId($id)
    {
        $this->setData(self::USER_ID, $id);
    }

    /**
     * Set Original User Id
     *
     * @return RoleInterface
     */
    public function setOriginalId($originalId)
    {
        $this->setData(self::ORIGINAL_USER_ID, $originalId);
    }

    /**
     * Set Secret
     *
     * @return RoleInterfacel
     */
    public function setUserSecret($secret)
    {
        $this->setData(self::USER_SECRET, $secret);
    }

    /**
     * Set Time Shift
     *
     * @return RoleInterfacel
     */
    public function setTimeShift($timeShift)
    {
        $this->setData(self::TIME_SHIFT, $timeShift);
    }

    /**
     * Set Is Active
     *
     * @return RoleInterfacel
     */
    public function setIsActive($value)
    {
        $this->setData(self::IS_ACTIVE, $value);
    }

    /**
     * Set IP Enabled
     *
     * @return RoleInterfacel
     */
    public function setIpEnabled($enabled)
    {
        $this->setData(self::IP_ENABLED, $enabled);
    }
    
    /**
     * Set IP List
     *
     * @return RoleInterfacel
     */
    public function setIpList($list)
    {
        $this->setData(self::IP_LIST, $list);
    }
    
    /**
     * Set Email Enabled
     *
     * @return RoleInterfacel
     */
    public function setEmailCodeEnabled($enabled)
    {
        $this->setData(self::EMAIL_CODE_ENABLED, $enabled);
    }
    
    /**
     * Load object by ID
     *
     * @param integer $originalId
     *
     * @return $this
     */
    public function loadOriginal($originalId)
    {
        $this->_getResource()->load($this, $originalId, self::ORIGINAL_USER_ID);
        return $this;
    }
    
    /**
     * Load object data
     *
     * @param integer $modelId
     * @param null|string $field
     *
     * @return $this
     */
    public function load($key, $field = null)
    {
        if (!is_numeric($key)) {
            $this->_getResource()->load($this, $key, $field);

            return $this;
        }

        return parent::load($key, $field);
    }
}
