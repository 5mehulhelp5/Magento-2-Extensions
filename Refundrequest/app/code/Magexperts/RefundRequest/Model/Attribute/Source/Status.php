<?php
/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category   Magexperts
 * @package    Magexperts_RefundRequest
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\RefundRequest\Model\Attribute\Source;

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magexperts\RefundRequest\Model\ResourceModel\Status as magexpertsRefundStatus;

class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Remind Status values
     */
    const PENDING = 0;
    const ACCEPT = 1;
    const REJECT = 2;
    const NA = null;
    /**
     * To Option Array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => self::PENDING,  'label' => __('Pending')],
            ['value' => self::ACCEPT,  'label' => __('Accept')],
            ['value' => self::REJECT,  'label' => __('Reject')],
            ['value' => self::NA,  'label' => __('N/A')]
        ];
    }
}
