<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\AutoRelatedProduct\Observer\Frontend\Layout;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magexperts\AutoRelatedProduct\Api\ConfigInterface as Config;
use Magexperts\AutoRelatedProduct\Model\RuleManager;

class GenerateBlocksAfter implements ObserverInterface
{
    /**
     * @var string PARENT_BlOCK_NAME
     */
    const PARENT_BlOCK_NAME = 'product.info.details';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var RuleManager
     */
    protected $ruleManager;

    /**
     * @param Config $config
     * @param RuleManager $ruleManager
     */
    public function __construct(
        Config $config,
        RuleManager $ruleManager
    ) {
        $this->config = $config;
        $this->ruleManager = $ruleManager;
    }

    /**
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        if (!$this->config->isEnabled()) {
            return;
        }

        $block = $observer->getLayout()->getBlock(self::PARENT_BlOCK_NAME);

        if (!$block || !$rule = $this->ruleManager->getRuleForPosition('product_content_tab')) {
            return;
        }

        $block->addChild(
            'autorp_tab',
            \Magexperts\AutoRelatedProduct\Block\RelatedProductList::class,
            [
                'title' => $rule->getData('block_title'),
                'isTab'=> 1,
                'rule' => $rule
            ]
        );
    }
}
