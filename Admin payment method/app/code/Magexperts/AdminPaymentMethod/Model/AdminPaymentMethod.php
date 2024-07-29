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
 * @package   Magexperts_AdminPaymentMethod
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\AdminPaymentMethod\Model;

/**
 * Class AdminPaymentMethod
 *
 * @package Magexperts\AdminPaymentMethod\Model
 */
class AdminPaymentMethod extends \Magento\Payment\Model\Method\AbstractMethod
{
    /**
     * Payment code
     *
     * @var string|bool
     */
    const CODE = 'adminpaymentmethod';

    /**
     * @var string
     */
    protected $_code = self::CODE;

    /**
     * @var bool
     */
    protected $_isOffline = true;

    /**
     * @var bool
     */
    protected $_canUseCheckout = false;

    /**
     * @var bool
     */
    protected $_canUseInternal = true;

    /**
     * Get preselect option from config
     *
     * @return string
     */
    public function getDataPreSelect()
    {
        return $this->getConfigData('preselect');
    }

    /**
     * Get Auto Create Invoice option from config
     *
     * @return bool
     */
    public function getDataAutoCreateInvoice()
    {
        return $this->getConfigData('createinvoice');
    }
}
