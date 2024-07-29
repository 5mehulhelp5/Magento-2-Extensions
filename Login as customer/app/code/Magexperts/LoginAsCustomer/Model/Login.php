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
 * @package    Magexperts_LoginAsCustomer
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2020 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\LoginAsCustomer\Model;

/**
 * Class Login
 *
 * @package Magexperts\LoginAsCustomer\Model
 */
class Login extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'bss_login_as_customer';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'loginascustomer_login';

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var \Magento\Customer\Model\Customer
     */
    protected $customer;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magexperts\LoginAsCustomer\Helper\Data
     */
    protected $helperData;

    /**
     * Login constructor.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magexperts\LoginAsCustomer\Helper\Data $helperData
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magexperts\LoginAsCustomer\Helper\Data $helperData,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->customerFactory = $customerFactory;
        $this->customerSession = $customerSession;
        $this->helperData = $helperData;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magexperts\LoginAsCustomer\Model\ResourceModel\Login');
    }

    /**
     * Retrieve not used admin login
     *
     * @param  string $secret
     * @return \Magento\Framework\DataObject
     */
    public function loadNotUsed($secret)
    {
        return $this->getCollection()
            ->addFieldToFilter('secret', $secret)
            ->addFieldToFilter('used', 0)
            ->addFieldToFilter('created_at', ['gt' => $this->helperData->getDateTimePoint()])
            ->setPageSize(1)
            ->getLastItem();
    }

    /**
     * Delete not used credentials
     *
     * @return void
     */
    public function deleteNotUsed()
    {
        $resource = $this->getResource();
        $resource->getConnection()->delete(
            $resource->getTable('bss_login_as_customer'),
            [
                'created_at < ?' => $this->helperData->getDateTimePoint(),
                'used = ?' => 0,
            ]
        );
    }

    /**
     * Retrieve customer
     *
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomer()
    {
        if (empty($this->customer)) {
            $this->customer = $this->customerFactory->create()
                ->load($this->getCustomerId());
        }
        return $this->customer;
    }

    /**
     * Login customer
     *
     * @return \Magento\Customer\Model\Customer
     * @throws \Exception
     */
    public function authenticateCustomer()
    {
        $customer = $this->getCustomer();

        if (!$customer->getId()) {
            throw new \Exception(__("Customer are no longer exist."), 1);
        }

        if ($this->customerSession->loginById($customer->getId())) {
            $this->customerSession->regenerateId();
            $this->customerSession->setLoggedAsCustomerAdmindId(
                $this->getAdminId()
            );
        }

        $this->setUsed(1)->save();

        return $customer;
    }

    /**
     * Save data
     *
     * @param int $adminId
     * @return Login
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function generate($adminId)
    {
        return $this->setData([
            'customer_id' => $this->getCustomerId(),
            'admin_id' => $adminId,
            'secret' => $this->helperData->getRandomString(),
            'used' => 0,
            'created_at' => $this->helperData->gmtTimestamp(),
        ])->save();
    }
}
