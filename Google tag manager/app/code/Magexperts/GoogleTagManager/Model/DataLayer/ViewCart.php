<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Model\DataLayer;

use Magexperts\GoogleTagManager\Api\DataLayer\ViewCartInterface;
use Magexperts\GoogleTagManager\Model\AbstractDataLayer;
use Magexperts\GoogleTagManager\Model\Config;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Quote\Model\Quote;
use Magexperts\GoogleTagManager\Api\DataLayer\Cart\ItemInterface;
use Magento\Store\Model\StoreManagerInterface;

class ViewCart extends AbstractDataLayer implements ViewCartInterface
{
    /**
     * @var string
     */
    protected $ecommPageType = 'cart';

    /**
     * @var ItemInterface
     */
    private $gtmItem;

    /**
     * ViewCart constructor.
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
    public function get(Quote $quote): array
    {
        $items = [];
        $itemsQty = 0;
        $value = 0;

        foreach ($quote->getAllVisibleItems() as $quoteItem) {
            $item = $this->gtmItem->get($quoteItem);
            $items[] = $item;
            $itemsQty += $item['quantity'];
            $value += $item['price'] * $item['quantity'];
        }

        return $this->eventWrap([
            'event' => 'view_cart',
            'ecommerce' => [
                'currency' => $this->getCurrentCurrencyCode(),
                'value' => $this->formatPrice($value),
                'items' => $items
            ],
            'items_count' => count($items),
            'items_qty' => $itemsQty,
            'coupon_code' => $quote->getCouponCode() ?: '',
            'customer_identifier' => $quote->getCustomerEmail() ? hash('sha256', (string)$quote->getCustomerEmail()) : ''
        ]);
    }
}
