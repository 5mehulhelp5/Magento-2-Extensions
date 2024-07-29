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
namespace Magexperts\LoginAsCustomer\Plugin;

use Magento\Customer\Controller\Account\LoginPost;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class SwitcherStore
 *
 * @package Magexperts\LoginAsCustomer\Plugin
 */
class SwitcherStore
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var Session
     */
    private $customerSession;
    /**
     * @var \Magento\Customer\Api\CustomerRepositoryInterface
     */
    private $customerRepositoryInterface;
    /**
     * @var UrlInterface
     */
    private $url;
    /**
     * @var \Magexperts\LoginAsCustomer\Helper\SwitchStore
     */
    private $switchStoreview;

    /**
     * SwitcherStore constructor.
     * @param StoreManagerInterface $storeManager
     * @param Session $customerSession
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     * @param UrlInterface $url
     * @param \Magexperts\LoginAsCustomer\Helper\SwitchStore $switchStoreview
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Session $customerSession,
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        UrlInterface $url,
        \Magexperts\LoginAsCustomer\Helper\SwitchStore $switchStoreview
    ) {
        $this->storeManager = $storeManager;
        $this->customerSession = $customerSession;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->url = $url;
        $this->switchStoreview = $switchStoreview;
    }

    /**
     * After Customer Login
     *
     * @param LoginPost $subject
     * @param string $result
     * @return mixed
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Store\Model\StoreSwitcher\CannotSwitchStoreException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterExecute(
        LoginPost $subject,
        $result
    ) {
        $customerId = $this->customerSession->getCustomerId();
        $storeId = null;
        if ($customerId) {
            if (isset($customer['store_id'])) {
                $storeId = $customer['store_id'];
            }
            if ($this->customerRepositoryInterface->getById($customerId)) {
                $customerStoreId = $this->customerRepositoryInterface->getById($customerId)->getStoreId();
            } else {
                $customerStoreId = null;
            }

            if ($customerStoreId !== null) {
                $storeId = $customerStoreId;
            }
            $storeCode = $this->storeManager->getStore($storeId)->getCode();
            $url = $this->url->getCurrentUrl();
            $this->switchStoreview->switchStoreView($url, $storeCode);
        }
        return $result;
    }
}
