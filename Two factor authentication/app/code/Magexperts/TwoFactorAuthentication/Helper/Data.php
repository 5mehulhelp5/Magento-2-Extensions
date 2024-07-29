<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_TwoFactorAuthentication
 */

/**
 * Copyright © 2016 Magexperts. All rights reserved.
 */
namespace Magexperts\TwoFactorAuthentication\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var string
     */
    const LOGIN_FIELD_NAME = 'otp_password';
    
    /**
     * @var string
     */
    const OTP_EMAIL_TEMPLATE = 'otp_email';
}
