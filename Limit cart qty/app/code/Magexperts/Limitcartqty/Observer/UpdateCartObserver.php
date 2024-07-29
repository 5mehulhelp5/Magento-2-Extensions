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

use Magexperts\Limitcartqty\Helper\CheckoutFlag;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class UpdateCartObserver
 *
 * @package Magexperts\Limitcartqty\Observer
 */
class UpdateCartObserver implements ObserverInterface
{
    /**
     * @var CheckoutFlag
     */
    protected $checkoutFlag;

    /**
     * UpdateCartObserver constructor.
     *
     * @param CheckoutFlag $checkoutFlag
     */
    public function __construct(
        CheckoutFlag $checkoutFlag
    ) {
        $this->checkoutFlag = $checkoutFlag;
    }

    /**
     * Execute
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $this->checkoutFlag->resetCart();
    }
}
