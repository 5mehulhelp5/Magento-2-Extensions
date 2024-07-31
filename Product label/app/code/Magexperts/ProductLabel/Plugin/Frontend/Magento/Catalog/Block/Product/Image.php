<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\ProductLabel\Plugin\Frontend\Magento\Catalog\Block\Product;

use Magexperts\ProductLabel\Model\Config;
use Magexperts\ProductLabel\Model\Parser\Html;

class Image
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
    )
    {
        $this->config = $config;
    }

    /**
     * @param $subject
     * @param $result
     * @return mixed|string
     */
    public function afterToHtml($subject, $result)
    {
        if ($this->config->isEnabled()) {
            $result = $this->addMfLabelContainerToImageWrapperTag($result, (int)$subject->getProductId());
        }

        return $result;
    }

    private function addMfLabelContainerToImageWrapperTag(string $html, int $productId): string
    {
        $wrapperClass = ltrim($this->config->getProductListContainerSelector(), '.');

        $imgTagPosition = strpos($html, '<img ');

        if ($imgTagPosition !== false) {
            $wrapperClassPosition = strpos($html, $wrapperClass);

            if ($wrapperClassPosition !== false) {
                $endOfTagWithWrapperClassPosition = strpos($html, '>', $wrapperClassPosition);

                if ($endOfTagWithWrapperClassPosition !== false) {
                    $mfPlContainer = Html::COMMENT_PREFIX . $productId . Html::COMMENT_SUFFIX;

                    $html = substr_replace($html, $mfPlContainer, $endOfTagWithWrapperClassPosition + 1, 0);
                }
            }
        }

        return $html;
    }
}
