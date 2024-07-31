<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\ProductLabel\Block\Adminhtml;

use Magento\Framework\App\ObjectManager;
use Magexperts\Community\Model\Section;

/**
 * Class Check EnableInfo Block
 */
class CheckEnableInfo extends \Magento\Backend\Block\Template
{
    /**
     * @var \Magexperts\ProductLabel\Model\Config
     */
    protected $config;

    /**
     * CheckEnableInfo constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magexperts\ProductLabel\Model\Config $config
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magexperts\ProductLabel\Model\Config $config,
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
