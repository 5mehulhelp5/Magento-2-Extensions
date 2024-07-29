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
namespace Magexperts\LoginAsCustomer\Plugin;

/**
 * Class FrontendUrl
 *
 * @package Magexperts\LoginAsCustomer\Plugin
 */
class FrontendUrl
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $frontendUrl;

    /**
     * FrontendUrl constructor.
     * @param \Magento\Framework\UrlInterface $frontendUrl
     */
    public function __construct(
        \Magento\Framework\UrlInterface $frontendUrl
    ) {
        $this->frontendUrl = $frontendUrl;
    }

    /**
     * Get fronted url
     *
     * @return \Magento\Framework\UrlInterface
     */
    public function getFrontendUrl()
    {
        return $this->frontendUrl;
    }
}
