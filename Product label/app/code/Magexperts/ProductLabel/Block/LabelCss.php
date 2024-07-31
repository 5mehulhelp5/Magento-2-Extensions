<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\ProductLabel\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magexperts\ProductLabel\Model\Config;

class LabelCss extends Template
{
    /**
     * @var string
     */
    public $_template = 'Magexperts_ProductLabel::label-css.phtml';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Context $context
     * @param Config $config
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $config,
        array $data = []
    )
    {
        $this->config = $config;
        parent::__construct($context, $data);
    }

    public function getConfig(): Config
    {
        return $this->config;
    }
}
