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
namespace Magexperts\LoginAsCustomer\Model\PageCache;

/**
 * Page cache config plugin
 */
class ConfigPlugin
{
    /**
     * @var \Magexperts\LoginAsCustomer\Helper\Data
     */
    protected $helper;

    /**
     * Initialize dependencies.
     *
     * @param \Magexperts\LoginAsCustomer\Helper\Data $helper
     */
    public function __construct(
        \Magexperts\LoginAsCustomer\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Disable page cache if needed when admin is logged as customer
     *
     * @param \Magento\PageCache\Model\Config $subject
     * @param bool $result
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterIsEnabled(\Magento\PageCache\Model\Config $subject, $result)
    {
        if ($result) {
            $disable = $this->helper->isDisablePageCache();
            $moduleEnable = $this->helper->isEnable();
            if ($disable && $moduleEnable) {
                $result = false;
            }
        }
        return $result;
    }
}
