<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Block\DataLayer;

use Magexperts\GoogleTagManager\Block\AbstractDataLayer;
use Magexperts\GoogleTagManager\Model\Config;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Context;
use Magexperts\GoogleTagManager\Api\DataLayer\PurchaseInterface;

class Purchase extends AbstractDataLayer
{
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var PurchaseInterface
     */
    private $purchase;

    /**
     * Purchase constructor.
     *
     * @param Context $context
     * @param Config $config
     * @param CheckoutSession $checkoutSession
     * @param PurchaseInterface $purchase
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $config,
        CheckoutSession $checkoutSession,
        PurchaseInterface $purchase,
        array $data = []
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->purchase = $purchase;
        parent::__construct($context, $config, $data);
    }

    /**
     * Get GTM datalayer for checkout success page
     *
     * @return array
     * @throws NoSuchEntityException
     */
    protected function getDataLayer(): array
    {
        $order = $this->getOrder();
        return $this->purchase->get($order);
    }

    /**
     * @return \Magento\Sales\Model\Order
     */
    protected function getOrder()
    {
        return $this->checkoutSession->getLastRealOrder();
    }
}
