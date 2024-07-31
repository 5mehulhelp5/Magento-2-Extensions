<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Model\Config\Source;

use Magexperts\Blog\Model\Url;

/**
 * Used in creating options for permalink config value selection
 */
class PermalinkType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => Url::PERMALINK_TYPE_DEFAULT,
                'label' => __('Default: mystore.com/{blog_route}/{post_route}/post-title/')
            ],
            [
                'value' => Url::PERMALINK_TYPE_SHORT,
                'label' => __('Short: mystore.com/{blog_route}/post-title/')
            ],
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }
        return $array;
    }
}
