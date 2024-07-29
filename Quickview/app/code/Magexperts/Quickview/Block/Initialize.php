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
 * @package    Magexperts_Quickview
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2020 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\Quickview\Block;

use Exception;

/**
 * Quickview Initialize block
 */
class Initialize extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magexperts\QuickView\Helper\Data
     */
    protected $helper;

    /**
     * @param \Magexperts\Quickview\Helper\Data $helper
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magexperts\Quickview\Helper\Data $helper,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Returns config
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getConfig()
    {
        return [
            'baseUrl' => $this->getBaseUrl()
        ];
    }

    /**
     * Class Helper::Data
     *
     * @return \Magexperts\QuickView\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * Return base url.
     *
     * @codeCoverageIgnore
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseUrl()
    {
        try {
            return $this->_storeManager->getStore()->getBaseUrl();
        } catch (Exception $e) {
            return null;
        }
    }
}
