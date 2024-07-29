<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_TwoFactorAuthentication
 */

/**
 * Copyright © 2016 Magexperts. All rights reserved.
 */
namespace Magexperts\TwoFactorAuthentication\Api\Data;

interface UserInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const USER_ID            = "user_id";
    const ORIGINAL_USER_ID   = "original_user_id";
    const USER_SECRET        = "user_secret";
    const TIME_SHIFT         = "time_shift";
    const IS_ACTIVE          = "is_active";
    const IP_ENABLED         = "ip_enabled";
    const IP_LIST            = "ip_list";
    const EMAIL_CODE_ENABLED = "email_code_enabled";

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();

    /**
     * Get Original User Id
     *
     * @return int|null
     */
    public function getOriginalId();

    /**
     * Get Secret
     *
     * @return string
     */
    public function getUserSecret();

    /**
     * Get Time Shift
     *
     * @return int|null
     */
    public function getTimeShift();
    
    /**
     * Get Is Active
     *
     * @return int|null
     */
    public function getIsActive();

    /**
     * Get IP Restriction Enabled
     *
     * @return int|null
     */
    public function getIpEnabled();
    
    /**
     * Get IP List
     *
     * @return string|null
     */
    public function getIpList();
    
    /**
     * Get Email enabled
     *
     * @return int
     */
    public function getEmailCodeEnabled();
    
    /**
     * Set ID
     *
     * @return RoleInterface
     */
    public function setId($id);

    /**
     * Set Original Role Id
     *
     * @return RoleInterface
     */
    public function setOriginalId($originalId);

    /**
     * Set Secret
     *
     * @return RoleInterfacel
     */
    public function setUserSecret($secret);
    
    /**
     * Set Time Shift
     *
     * @return RoleInterfacel
     */
    public function setTimeShift($timeShift);
    
    /**
     * Set Is Active
     *
     * @return RoleInterfacel
     */
    public function setIsActive($isActive);
    
    /**
     * Set IP Restriction Enabled
     *
     * @return RoleInterfacel
     */
    public function setIpEnabled($ipEnabled);
    
    /**
     * Set IP List
     *
     * @return RoleInterfacel
     */
    public function setIpList($ipList);
    
    /**
     * Set Email enabled
     *
     * @return RoleInterfacel
     */
    public function setEmailCodeEnabled($enabled);
}
