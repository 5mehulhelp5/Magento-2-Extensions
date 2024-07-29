<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Block\Adminhtml;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Provider extends Field
{
    protected $_template = 'Magexperts_Smtp::config/provider.phtml';

    /**
     * @var \Magexperts\Smtp\Model\Providers
     */
    private $providers;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    private $jsonEncoder;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magexperts\Smtp\Model\Providers $providers,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        array $data = []
    ) {
        $this->providers = $providers;
        $this->jsonEncoder = $jsonEncoder;
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        /** @var \Magento\Backend\Block\Template $block */
        $block = $this->_layout->createBlock(\Magento\Backend\Block\Template::class);
        $block->setTemplate($this->_template)->setData('providers', $this->getProviderData());

        $html = parent::_getElementHtml($element);
        $html .= $block->toHtml();

        return $html;
    }

    /**
     * @return string
     */
    public function getProviderData()
    {
        return $this->jsonEncoder->encode($this->providers->getAllProviders());
    }
}
