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
 * @package    Magexperts_Core
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\Core\Block\Adminhtml;

use Magento\Framework\View\Element\Template;

/**
 * Class Popup
 * @package Magexperts\Core\Block\Adminhtml
 */
class Popup extends Template
{
    /**
     * @var \Magexperts\Core\Helper\Module
     */
    private $moduleHelper;

    /**
     * @var \Magexperts\Core\Helper\Data
     */
    private $bssHelper;

    /**
     * @var \Magexperts\Core\Helper\Api
     */
    private $apiHelper;

    /**
     * @var Header
     */
    private $headerBlock;

    /**
     * Popup constructor.
     * @param Template\Context $context
     * @param \Magexperts\Core\Helper\Data $bssHelper
     * @param \Magexperts\Core\Helper\Module $moduleHelper
     * @param \Magexperts\Core\Helper\Api $apiHelper
     * @param Header $headerBlock
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magexperts\Core\Helper\Data $bssHelper,
        \Magexperts\Core\Helper\Module $moduleHelper,
        \Magexperts\Core\Helper\Api $apiHelper,
        Header $headerBlock,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->moduleHelper = $moduleHelper;
        $this->bssHelper = $bssHelper;
        $this->apiHelper = $apiHelper;
        $this->headerBlock = $headerBlock;
    }

    /**
     * @return array|null
     */
    public function getModuleHasNewVersion()
    {
        if ($this->bssHelper->isEnablePopup()) {
            return $this->moduleHelper->getListNewModuleVersion();
        }
        return null;
    }

    /**
     * @return array
     */
    public function getPopupConfig()
    {
        return $this->apiHelper->getConfigs();
    }
}
