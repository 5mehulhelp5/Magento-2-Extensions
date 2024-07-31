<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Helper;

use Magento\Framework\App\Action\Action;
use Magento\Store\Model\ScopeInterface;

/**
 * Magexperts Blog Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_MFLAZYLOAD_ENABLED = 'mflazyzoad/general/enabled';

    /**
     * Retrieve translated & formated date
     * @param  string $format
     * @param  string $dateOrTime
     * @return string
     */
    public static function getTranslatedDate($format, $dateOrTime)
    {
        $time = is_numeric($dateOrTime) ? $dateOrTime : strtotime((string)$dateOrTime);
        $month = ['F' => '%1', 'M' => '%2'];

        foreach ($month as $from => $to) {
            $format = str_replace($from, $to, $format);
        }

        $date = date($format, $time);

        foreach ($month as $to => $from) {
            $date = str_replace($from, __(date($to, $time)), $date);
        }

        return $date;
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

    /**
     * @return mixed
     */
    public function isOriginMfLazyLoadEnable()
    {
        return $this->getConfig(self::XML_PATH_MFLAZYLOAD_ENABLED);
    }
}
