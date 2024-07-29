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
namespace Magexperts\LoginAsCustomer\Block\Adminhtml\Customer\Edit;

use Magexperts\LoginAsCustomer\Helper\Data;
use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Customer\Model\Session;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Login as customer button
 */
class Login extends GenericButton implements ButtonProviderInterface
{
    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $authorization;
    /**
     * @var Data
     */
    protected $helper;
    /**
     * @var \Magento\Backend\Model\Session
     */
    private $backendSession;

    /**
     * Login constructor.
     * @param Data $helper
     * @param Context $context
     * @param Registry $registry
     * @param \Magento\Backend\Model\Session $backendSession
     */
    public function __construct(
        Data $helper,
        Context $context,
        Registry $registry,
        \Magento\Backend\Model\Session $backendSession
    ) {
        $this->helper = $helper;
        parent::__construct($context, $registry);
        $this->authorization = $context->getAuthorization();
        $this->backendSession = $backendSession;
    }

    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        $customerId = $this->getCustomerId();
        $data = [];
        $canModify = $customerId && $this->authorization->isAllowed('Magexperts_LoginAsCustomer::login_button');
        if (($canModify) && ($this->helper->isEnable())) {
            $data = [
                'label' => __('Login As Customer'),
                'class' => 'login login-button',
                'on_click' => 'window.open( \'' . $this->getInvalidateTokenUrl() .
                    '\')',
                'sort_order' => 70,
            ];
        }
        return $data;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getInvalidateTokenUrl()
    {
        $customers = $this->backendSession->getCustomerData();
        $storeId = null;
        if (isset($customers['account']['store_id'])) {
            $storeId = $customers['account']['store_id'];
        }
        return $this->getUrl('loginascustomer/customer/login', ['customer_id' => $this->getCustomerId(),'store_id'=> $storeId]);
    }
}
