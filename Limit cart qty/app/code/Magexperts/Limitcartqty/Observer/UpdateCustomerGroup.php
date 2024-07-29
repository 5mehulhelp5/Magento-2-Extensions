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
namespace Magexperts\Limitcartqty\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class UpdateCustomerGroup
 *
 * @package Magexperts\Limitcartqty\Observer
 */
class UpdateCustomerGroup implements ObserverInterface
{
    /**
     * @var \Magexperts\Limitcartqty\Helper\CheckoutFlag
     */
    protected $checkoutFlag;

    /**
     * UpdateCustomerGroup constructor.
     *
     * @param \Magexperts\Limitcartqty\Helper\CheckoutFlag $checkoutFlag
     */
    public function __construct(
        \Magexperts\Limitcartqty\Helper\CheckoutFlag $checkoutFlag
    ) {
        $this->checkoutFlag = $checkoutFlag;
    }

    /**
     * Reset Cart
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $this->checkoutFlag->resetCart();
    }
}
