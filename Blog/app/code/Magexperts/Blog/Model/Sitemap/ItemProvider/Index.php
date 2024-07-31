<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Blog\Model\Sitemap\ItemProvider;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Sitemap\Model\SitemapItemInterfaceFactory;
use Magento\Sitemap\Model\ItemProvider\ItemProviderInterface;
use Magexperts\Blog\Api\SitemapConfigInterface;
use Magexperts\Blog\Model\Url;
use Magexperts\Blog\Model\Config;

class Index implements ItemProviderInterface
{
    /**
     * Sitemap config
     *
     * @var SitemapConfigInterface
     */
    private $sitemapConfig;

    /**
     * Sitemap item factory
     *
     * @var SitemapItemInterfaceFactory
     */
    private $itemFactory;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Url
     */
    private $blogUrl;

    /**
     * @param SitemapConfigInterface $sitemapConfig
     * @param SitemapItemInterfaceFactory $itemFactory
     */
    public function __construct(
        SitemapConfigInterface $sitemapConfig,
        SitemapItemInterfaceFactory $itemFactory,
        ScopeConfigInterface $scopeConfig,
        Url $blogUrl
    ) {
        $this->sitemapConfig = $sitemapConfig;
        $this->itemFactory = $itemFactory;
        $this->scopeConfig = $scopeConfig;
        $this->blogUrl = $blogUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems($storeId)
    {
        if (!$this->sitemapConfig->isEnabledSitemap(SitemapConfigInterface::HOME_PAGE, $storeId)) {
            return [];
        }

        $url = $this->blogUrl->getBasePath();

        $advancedPermalinkEnabled =  $this->scopeConfig->getValue(
            Config::XML_PATH_ADVANCED_PERMALINK_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );

        if (!$advancedPermalinkEnabled) {
            $redirectToNoSlash = $this->scopeConfig->getValue(
                Config::XML_PATH_REDIRECT_TO_NO_SLASH,
                ScopeInterface::SCOPE_STORE,
                $storeId
            );

            if (!$redirectToNoSlash) {
                $url = trim($url, '/') . '/';
            }
        }


        $items[] = $this->itemFactory->create([
            'url' => $url,
            'priority' => $this->sitemapConfig->getPriority(SitemapConfigInterface::HOME_PAGE, $storeId),
            'changeFrequency' => $this->sitemapConfig->getFrequency(SitemapConfigInterface::POSTS_PAGE, $storeId)
        ]);

        return $items;
    }
}
