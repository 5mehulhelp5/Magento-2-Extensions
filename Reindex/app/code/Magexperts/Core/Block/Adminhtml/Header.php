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

/**
 * Class Header
 * @package Magexperts\Core\Block\Adminhtml
 */
class Header extends \Magento\Config\Block\System\Config\Form
{
    /**
     * @var \Magexperts\Core\Helper\Api
     */
    private $apiHelper;

    /**
     * Header constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Config\Model\Config\Factory $configFactory
     * @param \Magento\Config\Model\Config\Structure $configStructure
     * @param \Magento\Config\Block\System\Config\Form\Fieldset\Factory $fieldsetFactory
     * @param \Magento\Config\Block\System\Config\Form\Field\Factory $fieldFactory
     * @param \Magexperts\Core\Helper\Api $apiHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Factory $configFactory,
        \Magento\Config\Model\Config\Structure $configStructure,
        \Magento\Config\Block\System\Config\Form\Fieldset\Factory $fieldsetFactory,
        \Magento\Config\Block\System\Config\Form\Field\Factory $fieldFactory,
        \Magexperts\Core\Helper\Api $apiHelper,
        array $data = []
    )
    {

        parent::__construct($context, $registry, $formFactory, $configFactory, $configStructure, $fieldsetFactory,
            $fieldFactory, $data);
        $this->apiHelper = $apiHelper;
    }

    /**
     * @param string $html
     * @return string
     */
    protected function _afterToHtml($html)
    {
        $config = $this->apiHelper->getConfigs();
        if (!empty($config)) {
            $blockHeaderHtml = $config['theme_header_block'];
            return $blockHeaderHtml . $html;
        }

        return $html;
    }
}
