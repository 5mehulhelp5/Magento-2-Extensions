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
 * @package    Magexperts_LazyImageLoader
 * @author     Extension Team
 * @copyright  Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\LazyImageLoader\Block;

class LazyLoad extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magexperts\LazyImageLoader\Helper\Data
     */
    protected $helper;

    /**
     * LazyLoad constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magexperts\LazyImageLoader\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magexperts\LazyImageLoader\Helper\Data $helper,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magexperts\LazyImageLoader\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }
}
