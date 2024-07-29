<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_TwoFactorAuthentication
 */

namespace Magexperts\TwoFactorAuthentication\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\Plugin\AuthenticationException;
use Magento\Store\Model\Store;

class LoginBackendObserver implements ObserverInterface
{
    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;
    
    /**
     * @var \Magento\Backend\App\ConfigInterface
     */
    protected $config;
    
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magexperts\TwoFactorAuthentication\Model\Authentication
     */
    protected $authModel;
    
    /**
     * @var \Magexperts\TwoFactorAuthentication\Model\User
     */
    protected $user;
    
    /**
     * @var \Magexperts\TwoFactorAuthentication\Model\Ip
     */
    protected $ipModel;
    
    /**
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $authStorage;

    /**
     * @var \Magento\User\Model\UserFactory
     */
    protected $userFactory;
    
    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magexperts\TwoFactorAuthentication\Model\Authentication $authModel
     * @param \Magexperts\TwoFactorAuthentication\Model\Ip $ipModel
     * @param \Magexperts\TwoFactorAuthentication\Model\User $user
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param \Magento\Backend\Model\Auth\Session $authStorage
     * @param \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
     * @param \Magento\Backend\App\ConfigInterface $config
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magexperts\TwoFactorAuthentication\Model\Authentication $authModel,
        \Magexperts\TwoFactorAuthentication\Model\Ip $ipModel,
        \Magexperts\TwoFactorAuthentication\Model\User $user,
        \Magento\User\Model\UserFactory $userFactory,
        \Magento\Backend\Model\Auth\Session $authStorage,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Backend\App\ConfigInterface $config
    ) {
        $this->request = $request;
        $this->authModel = $authModel;
        $this->ipModel = $ipModel;
        $this->user = $user;
        $this->userFactory = $userFactory;
        $this->authStorage = $authStorage;
        $this->transportBuilder = $transportBuilder;
        $this->config = $config;
    }

    /**
     * Check Login Backend
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @throws \Magento\Framework\Exception\Plugin\AuthenticationException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (!$this->authStorage->getAllowBackendAccountLoginCheck()) {
            return;
        }
        $this->authStorage->setAllowBackendAccountLoginCheck(false);
        
        $user         = $this->userFactory->create()->loadByUsername($observer->getEvent()->getUsername());
        $otpPassword  = $this->request->getPost('otp_password');
        $loginSuccess = $observer->getEvent()->getResult();
        
        if ($loginSuccess && $user->getId()) {
            $extUser = $this->user->loadOriginal($user->getId());
            
            if ($this->ipModel->userIpRestricted($extUser)) {
                throw new AuthenticationException(__('You did not sign in correctly or access restricted.'));
            }
            
            if ($this->authModel->userRestricted($extUser, $otpPassword)) {
                // enable second login step
                if (empty($otpPassword) && $extUser->getEmailCodeEnabled()) {
                    $this->_sendAdminOtpEmail($user, $this->authModel->createHotp($extUser));
                    // prepare verification form
                    $this->authStorage->setNeedVerification(true);
                    $this->authStorage->setTfaUser($user);
                    $this->authStorage->setUser(null);
                }
                
                throw new AuthenticationException(__('You did not sign in correctly or access restricted.'));
            }
        }
    }
    
    /**
     * Send admin one time password action
     *
     * @param mixed $user
     * @param string $newPassword
     *
     * @return void
     */
    protected function _sendAdminOtpEmail($user, $newPassword)
    {
        $transport = $this->transportBuilder->setTemplateIdentifier(
            \Magexperts\TwoFactorAuthentication\Helper\Data::OTP_EMAIL_TEMPLATE
        )
            ->setTemplateModel(\Magento\Email\Model\BackendTemplate::class)
            ->setTemplateOptions([
                'area'  => \Magento\Framework\App\Area::AREA_ADMINHTML,
                'store' => Store::DEFAULT_STORE_ID
            ])
            ->setTemplateVars([
                'user'     => $user,
                'password' => $newPassword
            ])
            ->setFrom($this->config->getValue(\Magento\User\Model\User::XML_PATH_FORGOT_EMAIL_IDENTITY))
            ->addTo($user->getEmail(), $user->getName())
            ->getTransport();

        $transport->sendMessage();
    }
}
