<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\AutoRelatedProduct\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magexperts\AutoRelatedProduct\Api\ConfigInterface;

/**
 * Class Check EnableInfo Block
 */
class CheckEnableInfo extends \Magento\Backend\Block\Template
{
    /**
     * @var \Magexperts\AutoRelatedProduct\Model\Config
     */
    protected $config;

    /**
     * @param Context $context
     * @param ConfigInterface $config
     * @param array $data
     */
    public function __construct(
        Context $context,
        ConfigInterface $config,
        array $data = []
    ) {
        $this->config = $config;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->config->isEnabled();
    }
}
