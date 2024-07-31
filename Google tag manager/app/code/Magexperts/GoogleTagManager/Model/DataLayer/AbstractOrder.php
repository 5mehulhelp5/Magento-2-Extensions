<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Model\DataLayer;

use Magexperts\GoogleTagManager\Model\AbstractDataLayer;
use Magexperts\GoogleTagManager\Model\Config;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Store\Model\StoreManagerInterface;
use Magexperts\GoogleTagManager\Api\DataLayer\Order\ItemInterface;

abstract class AbstractOrder extends AbstractDataLayer
{
    /**
     * @var ItemInterface
     */
    private $gtmItem;

    /**
     * Purchase constructor.
     *
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     * @param CategoryRepositoryInterface $categoryRepository
     * @param ItemInterface $gtmItem
     */
    public function __construct(
        Config $config,
        StoreManagerInterface $storeManager,
        CategoryRepositoryInterface $categoryRepository,
        ItemInterface $gtmItem
    ) {
        $this->gtmItem = $gtmItem;
        parent::__construct($config, $storeManager, $categoryRepository);
    }

    /**
     * @inheritDoc
     */
    public function get(Order $order, string $requester = ''): array
    {
        if ($order) {
            $items = [];
            foreach ($order->getAllVisibleItems() as $item) {
                $items[] = $this->gtmItem->get($item);
            }

            return $this->eventWrap([
                'event' => $this->getEventName(),
                'ecommerce' => [
                    'transaction_id' => $order->getIncrementId(),
                    'value' => $this->getValue($order),
                    'tax' => $this->formatPrice((float)$order->getTaxAmount()),
                    'shipping' => $this->formatPrice((float)$order->getShippingAmount()),
                    'currency' => $this->getCurrentCurrencyCode(),
                    'coupon' => $order->getCouponCode() ?: '',
                    'items' => $items
                ],
                'is_virtual' => (bool)$order->getIsVirtual(),
                'shipping_description' => $order->getShippingDescription(),
                'customer_is_guest' => (bool)$order->getCustomerIsGuest(),
                'customer_identifier' => hash('sha256', (string)$order->getCustomerEmail()),
            ]);
        }

        return [];
    }

    /**
     * @param Order $order
     * @return float
     */
    protected function getValue(Order $order): float
    {
        $orderValue = (float)$order->getGrandTotal();

        if (!$this->config->isPurchaseTaxEnabled()) {
            $orderValue -= $order->getTaxAmount();
        }

        if (!$this->config->isPurchaseShippingEnabled()) {
            $orderValue -= $order->getShippingAmount();
        }

        return $this->formatPrice($orderValue);
    }

    /**
     * @return string
     */
    abstract protected function getEventName(): string;
}
