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
namespace Magexperts\LoginAsCustomer\Controller\Customer;

use Magento\Framework\App\Action\Context;

/**
 * LoginAsCustomer login action
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magexperts\LoginAsCustomer\Model\LoginFactory
     */
    protected $bssLoginFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * Index constructor.
     * @param Context $context
     * @param \Magexperts\LoginAsCustomer\Model\LoginFactory $bssLoginFactory
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        Context $context,
        \Magexperts\LoginAsCustomer\Model\LoginFactory $bssLoginFactory,
        \Magento\Customer\Model\Session $customerSession
    ) {
        parent::__construct($context);
        $this->bssLoginFactory = $bssLoginFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $this->messageManager->getMessages(true);
        $login = $this->initLogin();
        if (!$login) {
            $this->_redirect('/');
            return;
        }

        $isLogIn = $this->customerSession->isLoggedIn();
        if ($isLogIn) {
            $this->customerSession->logout();
        }

        try {
            $login->authenticateCustomer();
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        $this->messageManager->addSuccess(
            __('You are logged in as customer: %1', $login->getCustomer()->getName())
        );

        $this->_redirect('*/*/proceed');
    }

    /**
     * Init login
     *
     * @return bool|\Magento\Framework\DataObject
     */
    protected function initLogin()
    {
        $secret = $this->getRequest()->getParam('secret');
        if (!$secret) {
            $this->messageManager->addError(__('Cannot login to account. No secret key provided.'));
            return false;
        }

        $oldStoreId = $this->getRequest()->getParam('oldStoreId');
        $login = $this->bssLoginFactory->create()->loadNotUsed($secret);
        if ($login->getId()) {
            if ($oldStoreId === null) {
                $this->messageManager->addNoticeMessage('The store view where this account has been created was deleted');
            }
            return $login;
        } else {
            $this->messageManager->addError(__('Cannot login to account. Secret key is not valid.'));
            return false;
        }
    }
}
