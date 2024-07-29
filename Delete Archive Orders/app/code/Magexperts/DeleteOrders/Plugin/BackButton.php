<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Plugin;

use Magexperts\DeleteOrders\Model\ArchiveRepository;

/**
 * Class BackButton
 * Class provides after Plugin on Magento\Sales\Block\Adminhtml\Order\View::getBackUrl
 * to replace "back" button url on order view
 */
class BackButton
{
    /**
     * @var ArchiveRepository
     */
    protected $archiveRepository;

    /**
     * @param ArchiveRepository $archiveRepository
     */
    public function __construct(ArchiveRepository $archiveRepository)
    {
        $this->archiveRepository = $archiveRepository;
    }

    /**
     * After get back url method
     *
     * @param array $subject
     * @param string $url
     * @return string
     */
    public function afterGetBackUrl($subject, $url)
    {
        $order_id = $subject->getRequest()->getParam("order_id");
        $order = $this->archiveRepository->getByOrderId($order_id);
        if ($order->getId()) {
            return $subject->getUrl("deleteorders/archiveorder");
        }
        return $url;
    }
}
