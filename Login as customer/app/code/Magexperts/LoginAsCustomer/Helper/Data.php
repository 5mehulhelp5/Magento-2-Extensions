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
 * @category   Magexperts
 * @package    Magexperts_LoginAsCustomer
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2020 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\LoginAsCustomer\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Math\Random;

/**
 * Class Data
 *
 * @package Magexperts\LoginAsCustomer\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const TIME_FRAME = 60;
    const XML_PATH_ENABLED = 'bss_loginAscustomer/general/enable';
    const XML_PATH_CUSTOMER_GRID_LOGIN_COLUMN = 'bss_loginAscustomer/general/customer_grid_login_column';
    const XML_PATH_DSIABLE_PAGE_CACHE = 'bss_loginAscustomer/general/disable_page_cache';

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * @var Random
     */
    protected $random;

    /**
     * Data constructor.
     * @param Context $context
     * @param DateTime $dateTime
     * @param Random $random
     */
    public function __construct(
        Context $context,
        DateTime $dateTime,
        Random $random
    ) {
        parent::__construct($context);
        $this->dateTime = $dateTime;
        $this->random = $random;
    }


    /**
     * Is enable
     *
     * @return mixed
     */
    public function isEnable()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get login column
     *
     * @return mixed
     */
    public function getCustomerGridLoginColumn()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_GRID_LOGIN_COLUMN,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Is diable page cache
     *
     * @return mixed
     */
    public function isDisablePageCache()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_DSIABLE_PAGE_CACHE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrieve login datetime point
     *
     * @return false|string
     */
    public function getDateTimePoint()
    {
        return date('Y-m-d H:i:s', $this->dateTime->gmtTimestamp() - self::TIME_FRAME);
    }

    /**
     * GMT timestamp
     *
     * @return int
     */
    public function gmtTimestamp()
    {
        return $this->dateTime->gmtTimestamp();
    }

    /**
     * Get random string
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getRandomString()
    {
        return $this->random->getRandomString(64);
    }
}
