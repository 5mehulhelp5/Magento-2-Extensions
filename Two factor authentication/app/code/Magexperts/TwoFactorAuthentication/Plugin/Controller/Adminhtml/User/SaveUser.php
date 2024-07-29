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

use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\AuthenticationException;

class SaveUser
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $authSession;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    protected $resultFactory;
    
    /**
     * @var \Magexperts\TwoFactorAuthentication\Model\User
     */
    protected $user;
    
    /**
     * @var \Magexperts\TwoFactorAuthentication\Model\Authentication
     */
    protected $authModel;

    /**
     * @var \Magento\User\Model\User
     */
    protected $adminUser;
    
    /**
     * SaveRole constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\User\Model\User $adminUser,
     * @param \Magexperts\TwoFactorAuthentication\Model\User $user
     * @param \Magexperts\TwoFactorAuthentication\Model\Authentication $authModel
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\User\Model\User $adminUser,
        \Magexperts\TwoFactorAuthentication\Model\User $user,
        \Magexperts\TwoFactorAuthentication\Model\Authentication $authModel
    ) {
        $this->request        = $context->getRequest();
        $this->authSession    = $authSession;
        $this->messageManager = $context->getMessageManager();
        $this->resultFactory  = $context->getResultFactory();
        $this->user           = $user;
        $this->authModel      = $authModel;
        $this->adminUser      = $adminUser;
    }

    /**
     * Validate and save admin settings
     *
     * @param \Magento\User\Controller\Adminhtml\User\Role\SaveRole $object
     * @param callable $proceed
     */
    public function aroundExecute(\Magento\User\Controller\Adminhtml\User\Save $object, callable $proceed)
    {
        $redirect       = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $userId         = (int)$this->request->getPost('user_id') ? : null;
        $isUpdateSecret = $this->request->getPost('magexperts_tfa_update');
        
        try {
            $this->_validateUser();
            
            $extUser = $this->user->loadOriginal($userId);
            $newData = $this->_getDataUpdated($extUser);
            
            $isUpdateSecret &= ($newData->getIsActive() || $newData->getEmailCodeEnabled());
            
            if (!$isUpdateSecret) {
                // reset secret
                $newData->setUserSecret($extUser->getUserSecret());
            // totp verifycation
            } elseif ($newData->getIsActive() &&
                !$this->authModel->verifySecurely($newData, $this->request->getPost('otp_password'))
            ) {
                throw new AuthenticationException(__('You have entered an invalid One-Time Password.'));
            }
        } catch (AuthenticationException $e) {
            $this->messageManager->addError($e->getMessage());
            $arguments = $userId ? ['user_id' => $userId] : [];
            return $redirect->setPath('*/*/edit', $arguments);
        }

        $return = $proceed();

        $newData->setOriginalUserId(
            $userId ? : $this->_getLastNewUser()->getId()
        );
        
        $extUser->setData($newData->getData())->save();
        
        return $return;
    }

    /**
     * Validate current user password
     *
     * @return $this
     * @throws UserLockedException
     * @throws \Magento\Framework\Exception\AuthenticationException
     */
    protected function _validateUser()
    {
        $password = $this->request->getParam(
            \Magento\User\Block\User\Edit\Tab\Main::CURRENT_USER_PASSWORD_FIELD
        );
        $user = $this->authSession->getUser();
        $user->performIdentityCheck($password);

        return $this;
    }
    
    /**
     * Init form data object
     *
     * @param \Magexperts\TwoFactorAuthentication\Model\User
     * @return \Magento\Framework\DataObject
     */
    protected function _getDataUpdated(\Magexperts\TwoFactorAuthentication\Model\User $user)
    {
        $params  = $this->request->getPost('magexperts_tfa');
        $newData = new \Magento\Framework\DataObject($user->getData());
        
        foreach ($params as $field => $value) {
            $newData->setData($field, $value);
        }
        
        return $newData;
    }
    
    /**
     * Returns Last Created User
     *
     * @return \Magento\User\Model\User
     */
    protected function _getLastNewUser()
    {
        return $this->adminUser->getCollection()->setOrder('user_id', 'DESC')->getFirstItem();
    }
}
