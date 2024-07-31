<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\AutoRelatedProduct\Plugin\Frontend\Magento\Catalog\Model\ResourceModel\Product\Link\Product;

use Magexperts\AutoRelatedProduct\Model\Config;
use Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection as RelatedCollection;

class Collection
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    )
    {
        $this->config = $config;
    }

    /**
     * @param RelatedCollection $subject
     * @param $result
     * @return mixed
     */
    public function afterGetSize(
        RelatedCollection $subject,
                          $result
    )
    {
        if (!$result && $this->config->isEnabled()) {
            $backtrace = \Magento\Framework\Debug::backtrace(true, true, false);
            if (strpos($backtrace, 'Magento\Catalog\Block\Product\ProductList\Related') !== false) {
                $collection = clone $subject;
                $result = count($collection->getitems());
                unset($collection);
            }
        }
        return $result;
    }
}