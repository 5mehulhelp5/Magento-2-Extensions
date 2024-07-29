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
 * =================================================================
 *
 * MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * Magexperts does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Magexperts does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   Magexperts
 * @package    Magexperts_OrderDetails
 * @author     Extension Team
 * @copyright  Copyright (c) 2015-2016 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\OrderDetails\Block;

class Tax extends \Magento\Tax\Block\Sales\Order\Tax
{
    /**
     * Tax helper
     * @var \Magento\Tax\Helper\Data
     */
    protected $helper;

    /**
     * Tax Constructor
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Tax\Model\Config $taxConfig
     * @param \Magento\Tax\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Tax\Model\Config $taxConfig,
        \Magento\Tax\Helper\Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $taxConfig, $data);
    }

    /**
     * Get Helper Tax
     * @return \Magento\Tax\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }
}
