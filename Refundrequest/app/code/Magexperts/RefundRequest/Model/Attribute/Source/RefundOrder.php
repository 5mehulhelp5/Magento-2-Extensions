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

use Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory;
use Magexperts\RefundRequest\Model\ResourceModel\Status;

class RefundOrder implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $orderStatusCollection;

    /**
     * @var Status
     */
    protected $magexpertsRefundStatus;

    /**
     * RefundOrder constructor.
     * @param CollectionFactory $orderStatusCollection
     * @param Status $magexpertsRefundStatus
     */
    public function __construct(
        CollectionFactory $orderStatusCollection,
        Status $magexpertsRefundStatus
    ) {
        $this->orderStatusCollection = $orderStatusCollection;
        $this->magexpertsRefundStatus = $magexpertsRefundStatus;
    }

    /**
     * @return \Magento\Sales\Model\ResourceModel\Order\Status\Collection
     */
    public function getStatus()
    {
        return $this->orderStatusCollection->create();
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $array = [];
        foreach ($this->getStatus() as $value) {
            $array[] = ['value' => $value->getStatus(), 'label' => $value->getLabel()];
        }
        return $array;
    }
}
