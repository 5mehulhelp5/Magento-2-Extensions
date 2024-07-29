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
 * @package    Magexperts_RefundRequest
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\RefundRequest\Helper;

class RecentOder
{

    /**
     * @var Data
     */
    protected $helperConfigAdmin;

    /**
     * RecentOder constructor.
     * @param Data $helperConfigAdmin
     */
    public function __construct(
        Data $helperConfigAdmin
    ) {
        $this->helperConfigAdmin = $helperConfigAdmin;
    }

    //General config admin
    /**
     * @return string
     */
    public function getTemplate()
    {
        if ($this->helperConfigAdmin->getConfigEnableModule()) {
            $template =  'Magexperts_RefundRequest::order/recent.phtml';
        } else {
            $template = 'Magento_Sales::order/recent.phtml';
        }

        return $template;
    }

    /**
     * @return string
     */
    public function getTemplateMyOder()
    {
        if ($this->helperConfigAdmin->getConfigEnableModule()) {
            $template =  'Magexperts_RefundRequest::order/history.phtml';
        } else {
            $template = 'Magento_Sales::order/history.phtml';
        }
        return $template;
    }
}
