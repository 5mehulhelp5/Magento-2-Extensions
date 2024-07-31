<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Magexperts\Blog\Model\Config\Source;

class BlogPages implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options int
     *
     * @return array
     */
    public function toOptionArray()
    {
        return  [
            ['value' => \Magexperts\Blog\Model\Config::CANONICAL_PAGE_TYPE_NONE, 'label' => __('Please select')],
            ['value' => \Magexperts\Blog\Model\Config::CANONICAL_PAGE_TYPE_ALL, 'label' => __('All Blog Pages')],
            ['value' => \Magexperts\Blog\Model\Config::CANONICAL_PAGE_TYPE_INDEX, 'label' => __('Blog Index Page')],
            ['value' => \Magexperts\Blog\Model\Config::CANONICAL_PAGE_TYPE_POST, 'label' => __('Blog Post Page')],
            ['value' => \Magexperts\Blog\Model\Config::CANONICAL_PAGE_TYPE_CATEGORY, 'label' => __('Blog Category Page')],
            ['value' => \Magexperts\Blog\Model\Config::CANONICAL_PAGE_TYPE_AUTHOR, 'label' => __('Blog Author Page')],
            ['value' => \Magexperts\Blog\Model\Config::CANONICAL_PAGE_TYPE_ARCHIVE, 'label' => __('Blog Archive Page')],
            ['value' => \Magexperts\Blog\Model\Config::CANONICAL_PAGE_TYPE_TAG, 'label' => __('Blog Tag Page')],
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
