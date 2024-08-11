<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Model\Config\Source;

/**
 * Used in creating options for commetns config value selection
 */
class CommetType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @const int
     */
    const DISABLED = 0;

    /**
     * @const string
     */
    const MAGEXPERTS = 'magexperts';

    /**
     * @const string
     */
    const FACEBOOK = 'facebook';

    /**
     * @const string
     */
    const DISQUS = 'disqus';

    /**
     * @const string
     */
    const GOOGLE = 'google';

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::DISABLED, 'label' => __('Disabled')],
            ['value' => self::MAGEXPERTS, 'label' => __('Use Magexperts Blog Comments')],
            ['value' => self::FACEBOOK, 'label' => __('Use Facebook Comments')],
            ['value' => self::DISQUS, 'label' => __('Use Disqus Comments')],
            /*['value' => self::GOOGLE, 'label' => __('Use Google Comments')],*/
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
