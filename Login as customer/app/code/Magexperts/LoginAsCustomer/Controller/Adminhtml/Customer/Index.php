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

use Magento\Backend\App\Action;

/**
 * LoginAsCustomer log action
 */
class Index extends Action
{

    /**
     * @var \Magexperts\LoginAsCustomer\Model\LoginFactory
     */
    protected $bssLoginFactory;

    /**
     * Index constructor.
     *
     * @param Action\Context $context
     * @param \Magexperts\LoginAsCustomer\Model\LoginFactory $bssLoginFactory
     */
    public function __construct(
        Action\Context $context,
        \Magexperts\LoginAsCustomer\Model\LoginFactory $bssLoginFactory
    ) {
        parent::__construct($context);
        $this->bssLoginFactory = $bssLoginFactory;
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        if ($this->getRequest()->getParam('ajax')) {
            $this->_forward('grid');
            return;
        }

        $this->bssLoginFactory->create()->deleteNotUsed();

        $this->_view->loadLayout();
        $this->_setActiveMenu('Magexperts_LoginAsCustomer::login_log');
        $title = __('Login As Customer Log ');
        $this->_view->getPage()->getConfig()->getTitle()->prepend($title);
        $this->_addBreadcrumb($title, $title);
        $this->_view->renderLayout();
    }

    /**
     * Check is allowed access
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magexperts_LoginAsCustomer::login_log');
    }
}
