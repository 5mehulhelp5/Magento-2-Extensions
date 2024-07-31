<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Blog\Model\Sitemap\ItemProvider;

use Magento\Sitemap\Model\SitemapItemInterfaceFactory;
use Magento\Sitemap\Model\ItemProvider\ItemProviderInterface;
use Magexperts\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magexperts\Blog\Api\SitemapConfigInterface;

class Post implements ItemProviderInterface
{
    /**
     * Sitemap config
     *
     * @var SitemapConfigInterface
     */
    private $sitemapConfig;

    /**
     * Blog post collection factory
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
        if (!$this->sitemapConfig->isEnabledSitemap(SitemapConfigInterface::POSTS_PAGE, $storeId)) {
            return [];
        }

        $collection = $this->collectionFactory->create()
            ->addStoreFilter($storeId)
            ->addActiveFilter()
            ->getItems();

        $items = array_map(function ($item) use ($storeId) {
            
            $data = [
                'url' => $item->getUrl(),
                'updatedAt' => $item->getUpdatedAt(),
                'priority' => $this->sitemapConfig->getPriority(SitemapConfigInterface::POSTS_PAGE, $storeId),
                'changeFrequency' => $this->sitemapConfig->getFrequency(SitemapConfigInterface::POSTS_PAGE, $storeId),
            ];

            $images = [];
            if ($item->getFeaturedImage()) {
                $images[] = new \Magento\Framework\DataObject(['url' => $item->getFeaturedImage()]);
            }
            if ($item->getGalleryImages()) {
                $images = array_merge( $images, $item->getGalleryImages());
            }

            if ($images) {
                $imagesCollection = new \Magento\Framework\DataObject();
                $imagesCollection->setTitle($item->getTitle());
                $imagesCollection->setThumbnail($images[0]->getUrl());
                $imagesCollection->setCollection($images);
                $data['images'] = $imagesCollection;
            }

            return $this->itemFactory->create($data);
        }, $collection);

        return $items;
    }
}
