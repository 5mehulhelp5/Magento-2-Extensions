<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class InstallGtmOptions implements OptionSourceInterface
{

    /**
     * @var array
     */
    protected $options;

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray(): array
    {
        if ($this->options === null) {
            $this->options[] = ['value' => 'use_public_id', 'label' => __('Public ID')];
            $this->options[] = ['value' => 'use_head_and_body_script', 'label' => __('Head Script and Body Noscript')];
        }

        return $this->options;
    }
}
