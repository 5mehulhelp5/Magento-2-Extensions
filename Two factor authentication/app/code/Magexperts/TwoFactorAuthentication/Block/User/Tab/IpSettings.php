<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_TwoFactorAuthentication
 */

/**
 * Copyright © 2016 Magexperts. All rights reserved.
 */
namespace Magexperts\TwoFactorAuthentication\Block\User\Tab;

class IpSettings extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $systemStore;

    /**
     * @var  \Magexperts\AdvancedPermissions\Model\Role
     */
    protected $user;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var
     */
    protected $roleManager;
    
    /**
     * @var \Magento\Framework\Data\FormFactory
     */
    protected $formFactory;
    
    /**
     * @var \Magexperts\TwoFactorAuthentication\Model\Ip
     */
    protected $ipModel;

    /**
     * Settings constructor.
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry             $registry
     * @param \Magento\Framework\App\Action\Context   $contextManager
     * @param \Magento\Framework\Data\FormFactory     $formFactory
     * @param \Magento\Store\Model\System\Store       $systemStore
     * @param \Magexperts\AdvancedPermissions\Model\Role   $roleGen
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Action\Context $contextManager,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magexperts\TwoFactorAuthentication\Model\User $user,
        \Magexperts\TwoFactorAuthentication\Model\Ip $ipModel,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->_objectManager = $contextManager->getObjectManager();
        $this->systemStore   = $systemStore;
        $this->user          = $user;
        $this->formFactory   = $formFactory;
        $this->ipModel       = $ipModel;
    }

    /**
     * Get tab label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('IP Restriction');
    }

    /**
     * Get tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Whether tab is available
     *
     * @return bool
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Whether tab is visible
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Is single store
     *
     * @return bool
     */
    public function isSingleStoreMode()
    {
        return $this->_storeManager->isSingleStoreMode();
    }

    /**
     * Get user from registry
     *
     * @return mixed
     */
    public function getUser()
    {
        if (!$this->roleManager) {
            $this->roleManager = $this->_coreRegistry->registry('permissions_user');
        }
        return $this->roleManager;
    }

    /**
     * get suffix
     *
     * @return string
     */
    public function getSuffix()
    {
        return 'setting';
    }

    /**
     * Get field from role
     *
     * @param $field
     *
     * @return mixed
     */
    public function getFieldValue($field)
    {
        return $this->getRole()->getData($field);
    }

    /**
     * Get field from Global
     *
     * @param $field
     *
     * @return int
     */
    public function getFieldValueUseConfig($field)
    {
        if ($this->getRole()->hasData($field)) {
            return $this->getRole()->getData($field);
        }

        return 1;
    }
    
    protected function _prepareForm()
    {
        $extUser   = $this->user->loadOriginal($this->getUser()->getId());
        
        $form      = $this->formFactory->create();
        $fieldset  = $form->addFieldset('ip_config_fieldset', ['legend' => __('Admin IP Restrictions')]);

        $fieldset->addField('note', 'note', [
            'text' => __('Make sure that specified IPs are <b>static</b>. Otherwise the account can be <b>locked</b>.')
        ]);
        
        $fieldset->addField(
            $extUser::IP_LIST,
            'text',
            [
                'name' => "magexperts_tfa[".$extUser::IP_LIST."]",
                'label' => __('Whitelisted IPs'),
                'class' => 'aittfa-ip-validate',
                'note' => 'Use a space to separate IPs. Example: 192.168.135.65 192.168.18.230<br>Leave empty for access from any location.'
            ]
        );
        
        $extUser->setData('current_ip', $this->ipModel->getCurrentIp());
        
        $fieldset->addField(
            $extUser::SHOW_IP_FIELD,
            'text',
            [
                'name' => $extUser::SHOW_IP_FIELD,
                'label' => __('Your Current IP'),
                'title' => __('Your Current IP'),
                'readonly' => 'true'
            ]
        );
        
        $form->setValues($extUser->getData());
        $this->setForm($form);
        
        return $this;
    }
}
