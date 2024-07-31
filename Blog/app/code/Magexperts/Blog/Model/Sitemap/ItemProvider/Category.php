<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Blog\Model\Sitemap\ItemProvider;

use Magento\Sitemap\Model\SitemapItemInterfaceFactory;
use Magento\Sitemap\Model\ItemProvider\ItemProviderInterface;
use Magexperts\Blog\Model\ResourceModel\Category\CollectionFactory;
use Magexperts\Blog\Api\SitemapConfigInterface;

class Category implements ItemProviderInterface
{
    /**
     * Sitemap config
     *
     * @var SitemapConfigInterface
     */
    private $sitemapConfig;

    /**
     * Blog category collection factory
     *
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Sitemap item factory
     *
     * @var SitemapItemInterfaceFactory
     */
    private $itemFactory;

    /**
     * @param SitemapConfigInterface $sitemapConfig
     * @param CollectionFactory $collectionFactory
     * @param SitemapItemInterfaceFactory $itemFactory
     */
    public function __construct(
        SitemapConfigInterface $sitemapConfig,
        CollectionFactory $collectionFactory,
        SitemapItemInterfaceFactory $itemFactory
    ) {
        $this->sitemapConfig = $sitemapConfig;
        $this->collectionFactory = $collectionFactory;
        $this->itemFactory = $itemFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems($storeId)
    {
        if (!$this->sitemapConfig->isEnabledSitemap(SitemapConfigInterface::CATEGORIES_PAGE, $storeId)) {
            return [];
        }

        $collection = $this->collectionFactory->create()
            ->addStoreFilter($storeId)
            ->addActiveFilter()
            ->getItems();

        $items = array_map(function ($item) use ($storeId) {
            return $this->itemFactory->create([
                'url' => $item->getUrl(),
                'updatedAt' => $item->getUpdatedAt(),
                'priority' => $this->sitemapConfig->getPriority(SitemapConfigInterface::CATEGORIES_PAGE, $storeId),
                'changeFrequency' => $this->sitemapConfig->getFrequency(SitemapConfigInterface::CATEGORIES_PAGE, $storeId),
            ]);
        }, $collection);

        return $items;
    }
}
