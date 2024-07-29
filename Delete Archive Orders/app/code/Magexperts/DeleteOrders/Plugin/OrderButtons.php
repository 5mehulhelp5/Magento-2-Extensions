<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Plugin;

use Magento\Backend\Block\Widget\Button\ButtonList;
use Magento\Backend\Block\Widget\Context;
use Magexperts\DeleteOrders\Model\ArchiveRepository;

/**
 * Class OrderButtons
 *
 * Plugin for order buttons
 */
class OrderButtons
{
    const ADMIN_ACL_RESOURCE_PREFIX = 'Magexperts_DeleteOrders::';

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var ArchiveRepository
     */
    protected $archiveRepository;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $authorization;

    /**
     * @var int
     */
    protected $orderId;

    /**
     * @var \Magento\Backend\Block\Widget\Button\ButtonList
     */
    protected $buttonList;

    /**
     * OrderButtons constructor.
     *
     * @param Context $context
     * @param ArchiveRepository $archiveRepository
     */
    public function __construct(Context $context, ArchiveRepository $archiveRepository)
    {
        $this->context = $context;
        $this->request = $context->getRequest();
        $this->archiveRepository = $archiveRepository;
        $this->authorization = $context->getAuthorization();
        $this->orderId =  $this->request->getParam("order_id");
    }

    /**
     * After method for get button list
     *
     * @param Context $context
     * @param ButtonList $buttonList
     * @return ButtonList
     */
    public function afterGetButtonList(Context $context, ButtonList $buttonList)
    {
        $this->buttonList = $buttonList;
        $archivedOrder = $this->archiveRepository->getByOrderId($this->orderId);
        if ($this->request->getFullActionName() == 'sales_order_view') {
            $this->generateButton('delete');
            if ($archivedOrder->getId()) {
                $this->generateButton('restore');
            } else {
                $this->generateButton('archive');
            }
        }
        return $this->buttonList;
    }

    /**
     * Generate button
     *
     * @param string $action
     */
    private function generateButton($action)
    {
        if ($this->authorization->isAllowed(self::ADMIN_ACL_RESOURCE_PREFIX . $action . '_action')) {
            $urlPath = $action == 'delete' ? 'deleteorders/deleteorder/' : 'deleteorders/archiveorder/';
            $message = __('Are you sure you want to ' . $action . ' an order?');
            $this->buttonList->add(
                $action . '_button',
                [
                    'label' => __(ucfirst($action)),
                    'onclick' => "confirmSetLocation(
                    '{$message}', 
                    '{$this->createUrl($urlPath . $action, $this->orderId)}')",
                ]
            );
        }
    }

    /**
     * Create url
     *
     * @param string $path
     * @param int $order_id
     * @return string
     */
    public function createUrl($path, $order_id)
    {
        return  $this->context->getUrlBuilder()->getUrl($path, ['order_id' => $order_id]);
    }
}
