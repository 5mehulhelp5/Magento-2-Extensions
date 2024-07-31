<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\ProductLabel\Plugin\Frontend\Magento\Catalog\Block\Product\View;

use Magexperts\ProductLabel\Model\Config;
use Magexperts\ProductLabel\Model\Parser\Html;

class Gallery
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * @param $subject
     * @param $result
     * @return mixed|string
     */
    public function afterToHtml($subject, $result)
    {
        if ($this->config->isEnabled()
            && ($product = $subject->getProduct())
            && (false !== strpos($result, 'gallery-placeholder__image')))
        {
           $result = $result . Html::COMMENT_PREFIX . $product->getId() . Html::COMMENT_SUFFIX;
        }

        return $result;
    }
}
