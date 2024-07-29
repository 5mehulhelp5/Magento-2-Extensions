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
namespace Magexperts\Limitcartqty\Plugin;

use Magexperts\Limitcartqty\Helper\CheckoutFlag;
use Magento\Framework\App\Response\Http;
use Magento\Framework\App\Response\HttpInterface;
use Magento\Framework\UrlFactory;

/**
 * Class MintotalRedirect
 *
 * @package Magexperts\Limitcartqty\Plugin
 */
class ValidateCheckoutPaypal
{
    /**
     * @var CheckoutFlag
     */
    protected $checkoutFlag;

    /**
     * @var Http
     */
    protected $response;

    /**
     * @var UrlFactory
     */
    protected $urlFactory;

    /**
     * ValidateCheckoutPaypal constructor.
     * @param CheckoutFlag $checkoutFlag
     * @param Http $response
     * @param UrlFactory $urlFactory
     */
    public function __construct(
        CheckoutFlag $checkoutFlag,
        Http $response,
        UrlFactory $urlFactory
    ) {
        $this->checkoutFlag = $checkoutFlag;
        $this->response = $response;
        $this->urlFactory = $urlFactory;
    }

    /**
     * AfterExecute
     *
     * @param \Magento\Paypal\Controller\Express\Start $subject
     * @param \Closure $proceed
     * @return Http|HttpInterface|mixed
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundExecute(\Magento\Paypal\Controller\Express\Start $subject, \Closure $proceed)
    {
        if ($this->checkoutFlag->isEnableToCheckout()) {
            return $proceed();
        } else {
            $cartUrl = $this->urlFactory->create()->getUrl('checkout/cart');
            return $this->response->setRedirect($cartUrl);
        }
    }
}
