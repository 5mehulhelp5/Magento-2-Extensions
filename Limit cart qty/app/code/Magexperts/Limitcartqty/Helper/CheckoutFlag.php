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

use Magexperts\Limitcartqty\Api\DataConfigInterface;
use Magento\Checkout\Model\Cart;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class CheckoutFlag
 *
 * @package Magexperts\Limitcartqty\Helper
 */
class CheckoutFlag extends AbstractHelper
{
    /**
     * @var DataConfigInterface
     */
    protected $dataConfig;
    /**
     * @var Session
     */
    protected $customerSession;
    /**
     * @var ManagerInterface
     */
    protected $messageManager;
    /**
     * @var CustomMessage
     */
    protected $customMessage;
    /**
     * @var Cart
     */
    protected $cart;

    /**
     * CheckoutFlag constructor.
     *
     * @param Context $context
     * @param Cart $cart
     * @param DataConfigInterface $dataConfig
     * @param Session $customerSession
     * @param ManagerInterface $messageManager
     * @param CustomMessage $customMessage
     */
    public function __construct(
        Context $context,
        Cart $cart,
        DataConfigInterface $dataConfig,
        Session $customerSession,
        ManagerInterface $messageManager,
        CustomMessage $customMessage
    ) {
        $this->cart = $cart;
        $this->dataConfig = $dataConfig;
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
        $this->customMessage = $customMessage;
        parent::__construct($context);
    }

    /**
     * Validate Checkout
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function validateCheckout()
    {
        return $this->validateMax() && $this->validateMin();
    }

    /**
     * Check Enable
     *
     * @return bool
     */
    public function isEnableToCheckout()
    {
        return $this->checkMax() && $this->checkMin();
    }

    /**
     * Validate Min
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function validateMin()
    {
        if ($this->checkMin()) {
            return true;
        } else {
            $this->messageManager->addError(
                $this->customMessage->getMinMessage(
                    round($this->getMinConfigCartQty()),
                    round($this->getCartQty())
                )
            );
            return false;
        }
    }

    /**
     * Validate Max
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function validateMax()
    {
        if ($this->checkMax()) {
            return true;
        } else {
            $this->messageManager->addError(
                $this->customMessage->getMaxMessage(
                    round($this->getMaxConfigCartQty()),
                    round($this->getCartQty())
                )
            );
            return false;
        }
    }

    /**
     * Check Max
     *
     * @return bool
     */
    public function checkMax()
    {
        $this->customerSession->setMaxConfigCartQty($this->dataConfig->getMaxValue());
        return !($this->getMaxConfigCartQty()
            && $this->getCartQty() > $this->getMaxConfigCartQty())
            || !$this->dataConfig->isModuleEnable();
    }

    /**
     * Check Min
     *
     * @return bool
     */
    public function checkMin()
    {
        $this->customerSession->setMinConfigCartQty($this->dataConfig->getMinValue());
        return !($this->getMinConfigCartQty()
            && $this->getCartQty() < $this->getMinConfigCartQty())
            || !$this->dataConfig->isModuleEnable();
    }

    /**
     * Get Min
     *
     * @return mixed
     */
    public function getMinConfigCartQty()
    {
        return $this->customerSession->getMinConfigCartQty();
    }

    /**
     * Get Max
     *
     * @return mixed
     */
    public function getMaxConfigCartQty()
    {
        return $this->customerSession->getMaxConfigCartQty();
    }

    /**
     * GetQty
     *
     * @return mixed
     */
    public function getCartQty()
    {
        if (!$this->customerSession->getCartQty()) {
            $this->customerSession->setCartQty($this->cart->getQuote()->getItemsQty());
        }
        return $this->customerSession->getCartQty();
    }

    /**
     * Reset Cart
     */
    public function resetCart()
    {
        $this->customerSession->setCartQty(null);
    }
}
