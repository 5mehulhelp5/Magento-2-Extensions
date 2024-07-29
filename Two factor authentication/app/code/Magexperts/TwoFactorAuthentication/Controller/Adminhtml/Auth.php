<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_TwoFactorAuthentication
 */

namespace Magexperts\TwoFactorAuthentication\Controller\Adminhtml;

/**
 *  Auth controller
 */
abstract class Auth extends \Magento\Backend\App\AbstractAction
{
    /**
     * User model factory
     *
     * @var \Magento\User\Model\UserFactory
     */
    protected $userFactory;

    /**
     * @var \Magexperts\TwoFactorAuthentication\Model\Authentication
     */
    protected $authModel;
    
    /**
     * @var \Magexperts\TwoFactorAuthentication\Model\Ip
     */
    protected $ipModel;

    /**
     * @var \Magexperts\TwoFactorAuthentication\Model\User
     */
    protected $user;
    
    /**
     * Construct
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\User\Model\UserFactory $userFactory
     * @param \Magexperts\TwoFactorAuthentication\Model\Authentication $authModel
     * @param \Magexperts\TwoFactorAuthentication\Model\Ip $ipModel
     * @param \Magexperts\TwoFactorAuthentication\Model\User $user
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\User\Model\UserFactory $userFactory,
        \Magexperts\TwoFactorAuthentication\Model\Authentication $authModel,
        \Magexperts\TwoFactorAuthentication\Model\Ip $ipModel,
        \Magexperts\TwoFactorAuthentication\Model\User $user
    ) {
        parent::__construct($context);
        $this->userFactory = $userFactory;
        $this->authModel = $authModel;
        $this->ipModel = $ipModel;
        $this->user = $user;
    }
    
    /**
     * Check if user has permissions to access this controller
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return true;
    }
}
