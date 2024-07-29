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
namespace Magexperts\LoginAsCustomer\Controller\Adminhtml\Customer;

use Magexperts\LoginAsCustomer\Plugin\FrontendUrl;
use Magento\Backend\App\Action;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Store\Api\StoreRepositoryInterface;

/**
 * LoginAsCustomer login action
 */
class Login extends Action
{

    /**
     * @var \Magexperts\LoginAsCustomer\Model\LoginFactory
     */
    protected $bssLoginFactory;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $session;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var FrontendUrl
     */
    protected $frontendUrl;
    /**
     * @var Action\Context
     */
    private $context;
    /**
     * @var \Magexperts\LoginAsCustomer\Helper\SwitchStore
     */
    private $switchStoreview;
    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    private $customerFactory;
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * Login constructor.
     * @param Action\Context $context
     * @param \Magexperts\LoginAsCustomer\Model\LoginFactory $bssLoginFactory
     * @param \Magento\Backend\Model\Auth\Session $session
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param FrontendUrl $frontendUrl
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magexperts\LoginAsCustomer\Helper\SwitchStore $switchStoreview
     * @param StoreRepositoryInterface $storeRepository
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Action\Context $context,
        \Magexperts\LoginAsCustomer\Model\LoginFactory $bssLoginFactory,
        \Magento\Backend\Model\Auth\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        FrontendUrl $frontendUrl,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magexperts\LoginAsCustomer\Helper\SwitchStore $switchStoreview,
        StoreRepositoryInterface $storeRepository,
        CustomerRepositoryInterface $customerRepository
    ) {
        parent::__construct($context);
        $this->bssLoginFactory = $bssLoginFactory;
        $this->session = $session;
        $this->storeManager = $storeManager;
        $this->frontendUrl = $frontendUrl;
        $this->context = $context;
        $this->messageManager = $context->getMessageManager();
        $this->switchStoreview = $switchStoreview;
        $this->customerFactory = $customerFactory;
        $this->storeRepository = $storeRepository;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $customerId = (int)$this->getRequest()->getParam('customer_id');
        $customers = $this->customerRepository->getById($customerId);
        $storeIds = $customers->getStoreId();
        if (!isset($storeId)) {
            $storeId = $this->storeManager->getStore(
                $customers->getStoreId()
            )->getId();
        }
        $login = $this->bssLoginFactory->create()->setCustomerId($customerId);
        $login->deleteNotUsed();
        $customer = $login->getCustomer();
        if (!$customer->getId()) {
            $this->messageManager->addError(__('Customer with this ID are no longer exist.'));
            $this->_redirect('customer/index/index');
            return;
        }
        $user = $this->session->getUser();
        $login->generate($user->getId());
        $store = $this->storeRepository->getById($storeId);
        $storeCode = $this->storeManager->getStore($storeId)->getCode();
        $url = $this->frontendUrl->getFrontendUrl()->setScope($store);

        $redirectUrl = $url->
        getUrl('loginascustomer/customer/index', ['secret' => $login->getSecret(), '_nosid' => true ,'oldStoreId' => $storeIds]);
        $this->getResponse()->setRedirect($redirectUrl);
        $this->switchStoreview->switchStoreView($redirectUrl, $storeCode);
    }

    /**
     * Get customer
     *
     * @return \Magento\Customer\Model\Customer
     */
    public function getCustomer()
    {
        return $this->customerFactory->create();
    }

    /**
     * Check is allowed access
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magexperts_LoginAsCustomer::login_button');
    }
}
