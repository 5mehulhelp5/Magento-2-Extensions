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
 * @category  Magexperts
 * @package   Magexperts_AdminShippingMethod
 * @author    Extension Team
 * @copyright Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\AdminShippingMethod\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 *
 * @package Magexperts\AdminShippingMethod\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var \Magento\Sales\Api\Data\OrderInterface
     */
    protected $orderInterface;

    /**
     * Data constructor.
     * @param Context $context
     * @param \Magento\Sales\Api\Data\OrderInterface $orderInterface
     */
    public function __construct(
        Context $context,
        \Magento\Sales\Api\Data\OrderInterface $orderInterface
    ) {
        $this->orderInterface  = $orderInterface;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function getOrder()
    {
        return $this->orderInterface;
    }
    /**
     * @param $storeId
     * @return mixed
     */
    public function getPreSelect($storeId)
    {
        return $this->scopeConfig->isSetFlag(
            'carriers/adminshippingmethod/pre_select',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param $storeId
     * @return mixed
     */
    public function getCreatInvoice($storeId)
    {
        return $this->scopeConfig->isSetFlag(
            'carriers/adminshippingmethod/createinvoice',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param $storeId
     * @return mixed
     */
    public function getCreatShipment($storeId)
    {
        return $this->scopeConfig->isSetFlag(
            'carriers/adminshippingmethod/createshipment',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param $storeId
     * @return mixed
     */
    public function getName($storeId)
    {
        return $this->scopeConfig->getValue(
            'carriers/adminshippingmethod/name',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param $storeId
     * @return mixed
     */
    public function getTitle($storeId)
    {
        return $this->scopeConfig->getValue(
            'carriers/adminshippingmethod/title',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
    
    /**
     * @param $storeId
     * @return mixed
     */
    public function getError($storeId)
    {
        return $this->scopeConfig->getValue(
            'carriers/adminshippingmethod/specificerrmsg',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
