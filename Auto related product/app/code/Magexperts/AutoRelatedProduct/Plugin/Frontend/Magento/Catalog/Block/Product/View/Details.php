<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\AutoRelatedProduct\Plugin\Frontend\Magento\Catalog\Block\Product\View;

use Magexperts\AutoRelatedProduct\Api\ConfigInterface as Config;

class Details
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
    ) {
        $this->config = $config;
    }

    /**
     * @param \Magento\Catalog\Block\Product\View\Details $subject
     * @param $result
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterGetGroupSortedChildNames(\Magento\Catalog\Block\Product\View\Details $subject, $result)
    {
        return ($this->config->isEnabled() && $subject->getLayout()->isBlock('product.info.details.autorp_tab'))
            ? array_merge($result, [45 => 'product.info.details.autorp_tab'])
            : $result;
    }
}
