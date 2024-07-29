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
namespace Magexperts\RefundRequest\Model;

use Magento\Framework\Model\AbstractModel;

class Request extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(\Magexperts\RefundRequest\Model\ResourceModel\Request::class);
    }

    /**
     * @param $oderId
     */
    public function setOrderId($oderId)
    {
        $this->setData("increment_id", $oderId);
    }

    /**
     * @param $reasonComment
     */
    public function setReasonComment($reasonComment)
    {
        $this->setData("reason_comment", $reasonComment);
    }

    /**
     * @param $time
     */
    public function setTime($time)
    {
        $this->setData("create_at", $time);
    }

    /**
     * @param $option
     */
    public function setOption($option)
    {
        $this->setData("reason_option", $option);
    }

    /**
     * @param $radio
     */
    public function setRadio($radio)
    {
        $this->setData("radio_option", $radio);
    }

    /**
     * @param $customerName
     */
    public function setCustomerName($customerName)
    {
        $this->setData("customer_name", $customerName);
    }

    /**
     * @param $customerEmail
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->setData("customer_email", $customerEmail);
    }
}
