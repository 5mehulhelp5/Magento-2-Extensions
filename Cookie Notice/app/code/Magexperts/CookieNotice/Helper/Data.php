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
 * @package    Magexperts_CookieNotice
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\CookieNotice\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Retrieve Module Enable
     *
     * @return bool
     */
    public function isEnable()
    {
        return $this->scopeConfig->isSetFlag(
            'cookienotice/general/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Auto Hide Message
     *
     * @return int
     */
    public function getHideMsg()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/general/hide_msg',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/general/position',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Message Title
     *
     * @return string
     */
    public function getMsgTitle()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/notice_message/msg_title',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Title Text Color
     *
     * @return string
     */
    public function getColorTitle()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/notice_message/color_title',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Message
     *
     * @return string
     */
    public function getMsgContent()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/notice_message/msg_content',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Message Text Color
     *
     * @return string
     */
    public function getColorContent()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/notice_message/color_content',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Background Color
     *
     * @return string
     */
    public function getColorBg()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/notice_message/color_bg',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Text Acceptance Button
     *
     * @return string
     */
    public function getTextBtnAccept()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/btn_accept/text_btn_accept',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Text Color Acceptance Button
     *
     * @return string
     */
    public function getColorBtnAccept()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/btn_accept/color_btn_accept',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Background Color Acceptance Button
     *
     * @return string
     */
    public function getColorBgBtnAccept()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/btn_accept/color_bg_btn_accept',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Text More Information Button
     *
     * @return string
     */
    public function getTextBtnMoreInfor()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/btn_more_infor/text_btn_more_infor',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Text Color More Information Button
     *
     * @return string
     */
    public function getColorBtnMoreInfor()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/btn_more_infor/color_btn_more_infor',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Background Color More Information Button
     *
     * @return string
     */
    public function getColorBgBtnMoreInfor()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/btn_more_infor/color_bg_btn_more_infor',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get CMS Page
     *
     * @return string
     */
    public function getCMSPage()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/btn_more_infor/cms_page',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Custom Css
     *
     * @return string
     */
    public function getCustomStyle()
    {
        return $this->scopeConfig->getValue(
            'cookienotice/custom_style/custom_css',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
