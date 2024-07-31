<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Model\DataLayer;

use Magexperts\GoogleTagManager\Api\DataLayer\ViewItemInterface;
use Magexperts\GoogleTagManager\Model\Config;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magexperts\GoogleTagManager\Model\AbstractDataLayer;
use Magento\Store\Model\StoreManagerInterface;
use Magexperts\GoogleTagManager\Api\DataLayer\Product\ItemInterface;

class ViewItem extends AbstractDataLayer implements ViewItemInterface
{
    /**
     * @var string
     */
    protected $ecommPageType = 'product';

    /**
     * @var ItemInterface
     */
    private $gtmItem;

    /**
     * ViewItem constructor.
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
    public function get(Product $product): array
    {
        $item = $this->gtmItem->get($product);
        return $this->eventWrap([
            'event' => 'view_item',
            'ecommerce' => [
                'currency' => $this->getCurrentCurrencyCode(),
                'value' => $this->getProductValue($product),
                'items' => [
                    $item
                ]
            ]
        ]);
    }
}
