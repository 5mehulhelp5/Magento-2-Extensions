<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_TwoFactorAuthentication
 */

/**
 * Copyright © 2016 Magexperts. All rights reserved.
 */
namespace Magexperts\TwoFactorAuthentication\Plugin\Controller\Adminhtml\User;

class BeforeLogin
{
    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;
    
    /**
     * @var \Magexperts\TwoFactorAuthentication\Model\Authentication
     */
    protected $authModel;

    /**
     * BeforeLogin constructor.
     *
     * @param \Magento\Backend\Model\Auth\Session $authStorage,
     * @param \Magento\Backend\Model\View\Result\Redirect $resultRedirectFactory
     */
    public function __construct(
        \Magento\Backend\Model\Auth\Session $authStorage,
        \Magento\Backend\Model\View\Result\Redirect $resultRedirectFactory
    ) {
        $this->authStorage           = $authStorage;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    /**
     * Redirect to verification form
     *
     * @param \Magento\Backend\Controller\Adminhtml\Auth\Login $object
     * @param callable $proceed
     */
    public function aroundExecute(\Magento\Backend\Controller\Adminhtml\Auth\Login $object, callable $proceed)
    {
        if ($this->authStorage->getNeedVerification()) {
            $resultRedirect = $this->resultRedirectFactory;
            $resultRedirect->setPath('aitauth/auth/resetpassword');
            return $resultRedirect;
        }
        
        return $proceed();
    }
}
