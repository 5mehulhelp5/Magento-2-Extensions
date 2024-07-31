<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Model\Config\Source;

use Magento\Config\Model\Config\Source\Design\Robots;

/**
 * Class Tag Robots Model
 */
class TagRobots extends Robots
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = parent::toOptionArray();
        array_unshift($options, ['value' => '', 'label' => 'Use config settings']);
        return $options;
    }
}
