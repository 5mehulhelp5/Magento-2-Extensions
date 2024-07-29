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

class Authentication extends \Magento\Framework\Model\AbstractModel
{
    const SECRET_LENGTH = 16;

    const OTP_LENGTH = 6;

    const TIME_PERIOD = 30;

    const EMAIL_TIME_PERIOD = 180;

    const CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567=';

    const VALIDATION_WINDOW = 1;

    /**
     * Is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return true;
    }

    /**
     * Generate secret
     *
     * @return string
     */
    public function createAccountSecret()
    {
        // php 5.3.0
        $randBytes = openssl_random_pseudo_bytes(self::SECRET_LENGTH, $crypto_strong);

        if (!$crypto_strong) {
            throw new \Exception('Key generation error');
        }

        $secret = '';
        for ($i = 0; $i < self::SECRET_LENGTH; $i++) {
            $secret .= self::CHARS[ord($randBytes[$i]) & 31];
        }

        return $secret;
    }

    /**
     * Verify TOTP/HOTP
     *
     * @param mixed    $data
     * @param string   $password
     *
     * @return bool
     */
    public function userRestricted($data, $password)
    {
        if ($data->getIsActive() && $this->verifySecurely($data, $password)) {
            return false;
        }
        if ($data->getEmailCodeEnabled() &&
            (strlen($password) == self::OTP_LENGTH) &&
            hash_equals($this->createHotp($data), $password)
        ) {
            return false;
        }

        return ($data->getIsActive() || $data->getEmailCodeEnabled());
    }

    /**
     * Verify One-Time Password
     *
     * @param mixed    $data
     * @param string   $otp
     *
     * @return bool
     */
    public function verifySecurely($data, $otp)
    {
        if (strlen($otp) == self::OTP_LENGTH) {
            // compare otp with extended range of server generated otps
            for ($i=-self::VALIDATION_WINDOW; $i<=self::VALIDATION_WINDOW; $i++) {
                if (hash_equals($this->createTotp($data, $i), $otp)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Generate HOTP
     *
     * @param mixed $data
     *
     * @return string
     */
    public function createHotp($data)
    {
        $time = (int)floor(time() / self::EMAIL_TIME_PERIOD);

        return $this->createOtp($data->getUserSecret(), $time);
    }

    /**
     * Generate TOTP
     *
     * @param mixed $data
     *
     * @return string
     */
    public function createTotp($data, $window_shift = 0)
    {
        $time = (int)floor((time() + $data->getTimeShift()) / self::TIME_PERIOD);

        return $this->createOtp($data->getUserSecret(), $time + $window_shift);
    }

    /**
     * Generate OTP
     *
     * @param string $secret
     * @param int    $seed
     *
     * @return string
     */
    public function createOtp($secret, $seed)
    {
        $sTime  = "\0\0\0\0" . pack('N*', $seed);
        $hash   = hash_hmac('SHA1', $sTime, $this->_decode($secret), true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $tail   = substr($hash, $offset, 4);
        $value  = unpack('N', $tail)[1] & 0x7FFFFFFF;

        return str_pad($value % pow(10, self::OTP_LENGTH), self::OTP_LENGTH, '0', STR_PAD_LEFT);
    }

    /**
     * Decode base
     *
     * @param string $secret
     *
     * @return string
     */
    protected function _decode($secret)
    {
        if (empty($secret)) {
            return '';
        }
        $base32chars = str_split(self::CHARS);
        $base32charsFlipped = array_flip($base32chars);
        $paddingCharCount = substr_count($secret, $base32chars[32]);
        $allowedValues = [6, 4, 3, 1, 0];
        if (!in_array($paddingCharCount, $allowedValues)) {
            return false;
        }
        for ($i = 0; $i < 4; ++$i) {
            if ($paddingCharCount == $allowedValues[$i] &&
                substr($secret, -($allowedValues[$i])) != str_repeat($base32chars[32], $allowedValues[$i])) {
                return false;
            }
        }
        $secret = str_replace('=', '', $secret);
        $secret = str_split($secret);
        $binaryString = '';
        for ($i = 0; $i < count($secret); $i = $i + 8) {
            $x = '';
            if (!in_array($secret[$i], $base32chars)) {
                return false;
            }
            for ($j = 0; $j < 8; ++$j) {
                try {
                    $x .= str_pad(base_convert($base32charsFlipped[$secret[$i + $j]], 10, 2), 5, '0', STR_PAD_LEFT);
                } catch (\Exception $e) {
                }
            }
            $eightBits = str_split($x, 8);
            for ($z = 0; $z < count($eightBits); ++$z) {
                $binaryString .= (($y = chr(base_convert($eightBits[$z], 2, 10))) || ord($y) == 48) ? $y : '';
            }
        }
        return $binaryString;
    }

    /**
     * Returns the QR uri
     *
     * @param string $secret
     * @param string $account
     * @param string $company
     *
     * @return string
     */
    public function getQRUrl($secret, $account = '', $company = '')
    {
        $account = $account ?? '';
        $encode = 'otpauth://totp/' . urlencode($account) . '?secret=' . $secret;

        if (!empty($company)) {
            $encode .= '&issuer=' . urlencode($company);
        }
        return 'https://chart.googleapis.com/chart?chs=150x150&chld=M|0&cht=qr&chl=' . urlencode($encode);
    }
}
