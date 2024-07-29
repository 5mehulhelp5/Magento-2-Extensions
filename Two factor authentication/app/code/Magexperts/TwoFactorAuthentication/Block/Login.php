<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_TwoFactorAuthentication
 */

/**
 * Copyright © 2016 Magexperts. All rights reserved.
 */
namespace Magexperts\TwoFactorAuthentication\Block;

class Login extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = 'default.phtml';

    /**
     * @var \Magexperts\TwoFactorAuthentication\Model\Authentication
     */
    protected $authModel;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magexperts\TwoFactorAuthentication\Model\Authentication $authModel
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magexperts\TwoFactorAuthentication\Model\Authentication $authModel,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->authModel = $authModel;
    }

    /**
     * Returns template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->getIsAjax() ? '' : $this->_template;
    }

    /**
     * Renders HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if ($this->authModel->isEnabled()) {
            return parent::_toHtml();
        }
        return '';
    }
}
