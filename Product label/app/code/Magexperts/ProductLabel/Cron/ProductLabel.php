<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\ProductLabel\Cron;

/**
 * Apply Product Label rules
 */
class ProductLabel
{
    /**
     * @var \Magexperts\ProductLabel\Model\Config
     */
    protected $config;

    /**
     * @var \Magexperts\ProductLabel\Model\ProductLabelAction
     */
    protected $productLabelAction;

    /**
     * ProductLabel constructor.
     * @param \Magexperts\ProductLabel\Model\ProductLabelAction $productLabelAction
     * @param \Magexperts\ProductLabel\Model\Config $config
     */
    public function __construct(
        \Magexperts\ProductLabel\Model\ProductLabelAction $productLabelAction,
        \Magexperts\ProductLabel\Model\Config $config
    ) {
        $this->config = $config;
        $this->productLabelAction = $productLabelAction;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        if ($this->config->isEnabled()) {
            $this->productLabelAction->execute();
        }
    }
}
