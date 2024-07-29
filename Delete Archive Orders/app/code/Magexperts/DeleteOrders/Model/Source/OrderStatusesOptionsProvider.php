<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory;

/**
 * Class OrderStatusesOptionsProvider
 *
 * Add options to order statuses
 */
class OrderStatusesOptionsProvider implements OptionSourceInterface
{
    /**
     * @var $statusCollectionFactory
     */
    protected $statusCollectionFactory;

    /**
     * OrderStatusesOptionsProvider constructor.
     *
     * @param CollectionFactory $statusCollectionFactory
     */
    public function __construct(CollectionFactory $statusCollectionFactory)
    {
        $this->statusCollectionFactory = $statusCollectionFactory;
    }

    /**
     * Get status options
     *
     * @return array
     */
    public function getStatusOptions()
    {
        $options = $this->statusCollectionFactory->create()->toOptionArray();
        return $options;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getStatusOptions();
    }
}
