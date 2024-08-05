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
 * @package    Magexperts_DeleteOrder
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2019 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\DeleteOrder\Plugin\Shipment;

class PluginAfter extends \Magexperts\DeleteOrder\Plugin\PluginAbstract
{
    /**
     * @var \Magento\Backend\Helper\Data
     */
    protected $data;

    /**
     * PluginAfter constructor.
     * @param \Magento\Authorization\Model\Acl\AclRetriever $aclRetriever
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Backend\Helper\Data $data
     */
    public function __construct(
        \Magento\Authorization\Model\Acl\AclRetriever $aclRetriever,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Backend\Helper\Data $data
    ) {
        parent::__construct($aclRetriever, $authSession);
        $this->data = $data;
    }

    /**
     * @param \Magento\Shipping\Block\Adminhtml\View $subject
     * @param $result
     * @return mixed
     */
    public function afterGetBackUrl(\Magento\Shipping\Block\Adminhtml\View $subject, $result)
    {
        if ($this->isAllowedResources()) {
            $params = $subject->getRequest()->getParams();
            $message = __('Are you sure you want to do this?');
            if ($subject->getRequest()->getFullActionName() == 'adminhtml_order_shipment_view') {
                $subject->addButton(
                    'magexperts-delete',
                    ['label' => __('Delete'), 'onclick' => 'confirmSetLocation(\'' . $message . '\',\'' . $this->getDeleteUrl($params['shipment_id']) . '\')', 'class' => 'magexperts-delete'],
                    -1
                );
            }
        }

        return $result;
    }

    /**
     * @param string $shipmentId
     * @return mixed
     */
    public function getDeleteUrl($shipmentId)
    {
        return $this->data->getUrl(
            'deleteorder/delete/shipment',
            [
                'shipment_id' => $shipmentId
            ]
        );
    }
}
