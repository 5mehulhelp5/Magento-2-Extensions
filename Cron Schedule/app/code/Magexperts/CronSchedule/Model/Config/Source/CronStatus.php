<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\CronSchedule\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Cron\Model\Schedule;

class CronStatus implements OptionSourceInterface
{
    /**
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            Schedule::STATUS_PENDING => __('Pending'),
            Schedule::STATUS_RUNNING => __('Running'),
            Schedule::STATUS_SUCCESS => __('Success'),
            Schedule::STATUS_MISSED  => __('Missed'),
            Schedule::STATUS_ERROR   => __('Error'),
        ];
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];

        foreach ($this::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }
}
