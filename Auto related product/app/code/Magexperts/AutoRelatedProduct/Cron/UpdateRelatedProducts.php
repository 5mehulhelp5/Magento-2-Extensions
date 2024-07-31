<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
namespace Magexperts\AutoRelatedProduct\Cron;

use Magexperts\AutoRelatedProduct\Model\AutoRelatedProductAction;
use Magexperts\AutoRelatedProduct\Api\ConfigInterface as Config;

class UpdateRelatedProducts
{
    /**
     * @var AutoRelatedProductAction
     */
    protected $autoRelatedProductAction;

    /**
     * @var Config
     */
    protected $config;

    /**
     * BoughtUpdate constructor.
     * @param RelatedUpdater $relatedUpdater
     */
    public function __construct(
        AutoRelatedProductAction $autoRelatedProductAction,
        Config $config
    ) {
        $this->config = $config;
        $this->autoRelatedProductAction = $autoRelatedProductAction;
    }

    /**
     *
     */
    public function execute()
    {
        if ($this->config->isEnabled()) {
            $this->autoRelatedProductAction->execute();
        }
    }
}
