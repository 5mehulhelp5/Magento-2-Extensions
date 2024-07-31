<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magexperts\Blog\Model\Sitemap;

use Magexperts\Blog\Api\SitemapConfigInterface;

/**
 * Class Sitemap Config Model
 */
class SitemapConfig extends \Magexperts\Blog\Model\Config implements SitemapConfigInterface
{
    /**
     * @param $page
     * @param $storeId
     * @return bool
     */
    public function isEnabledSitemap($page, $storeId = null) : bool
    {
        return $this->isEnabled($storeId);
    }

    /**
     * @param $page
     * @param $storeId
     * @return string
     */
    public function getFrequency($page, $storeId = null): string
    {
        $frequency = '';

        switch ($page) {
            case 'index':
                $frequency = 'daily';
                break;
            case 'category':
                $frequency = 'daily';
                break;
            case 'post':
                $frequency = 'daily';
                break;
            default:
                $frequency = 'daily';
        }
        return $frequency;
    }

    /**
     * @param $page
     * @param $storeId
     * @return float
     */
    public function getPriority($page, $storeId = null): float
    {
        switch ($page) {
            case 'index':
                $priority = 1;
                break;
            case 'category':
                $priority = 0.8;
                break;
            case 'post':
                $priority = 0.5;
                break;
            default:
                $priority = 0.3;
        }
        return (float)$priority;
    }
}
