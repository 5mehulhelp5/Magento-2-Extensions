<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magexperts\Blog\Api;

/**
 * Interface SitemapConfigInterface
 */
interface SitemapConfigInterface
{
    const HOME_PAGE = 'index';
    const CATEGORIES_PAGE = 'category';
    const POSTS_PAGE = 'post';
    const TAGS_PAGE = 'tag';
    const AUTHOR_PAGE = 'author';

    /**
     * @param $page
     * @param $storeId
     * @return bool
     */
    public function isEnabledSitemap($page, $storeId = null): bool;

    /**
     * @param $page
     * @param $storeId
     * @return string
     */
    public function getFrequency($page, $storeId = null): string;

    /**
     * @param $page
     * @param $storeId
     * @return float
     */
    public function getPriority($page, $storeId = null): float;
}
