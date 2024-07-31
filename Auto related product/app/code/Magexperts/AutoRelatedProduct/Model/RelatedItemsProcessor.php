<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\AutoRelatedProduct\Model;

use Magexperts\AutoRelatedProduct\Model\RuleManager;
use Magexperts\AutoRelatedProduct\Api\RelatedItemsProcessorInterface;
use Magexperts\AutoRelatedProduct\Model\Config\Source\MergeType;
use Magento\Framework\View\Element\AbstractBlock;

class RelatedItemsProcessor implements RelatedItemsProcessorInterface
{
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
     * @param \Magexperts\AutoRelatedProduct\Model\RuleManager $ruleManager
     */
    public function __construct(
        Config $config,
        RuleManager $ruleManager
    ) {
        $this->config = $config;
        $this->ruleManager = $ruleManager;
    }

    /**
     * @param AbstractBlock $subject
     * @param $result
     * @param $blockPosition
     * @return \Magexperts\AutoRelatedProduct\Block\Collection|mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(AbstractBlock $subject, $result, $blockPosition)
    {
        if (!$this->config->isEnabled() || !$rule = $this->ruleManager->getRuleForPosition($blockPosition)) {
            return $result;
        }

        if ($rule->getMergeType() == MergeType::MERGE) {
            $resultCount = count($result);
            $limit = $rule->getNumberOfProducts();

            if ($resultCount >= $limit) {
                return $result;
            }

            $products = $subject->getLayout()->createBlock(
                \Magexperts\AutoRelatedProduct\Block\RelatedProductList::class
            )->setData('rule', $rule)->getItems();

            $resultIds = [];

            foreach ($result as $r) {
                $resultIds[] = $r->getId();
            }

            foreach ($products as $product) {
                if ($resultCount >= $limit) {
                    break;
                }

                if (in_array($product->getId(), $resultIds)) {
                    continue;
                }

                if (is_object($result)) {
                    $result->addItem($product);
                } else {
                    $result[] = $product;
                }

                $resultCount++;
            }
        } elseif ($rule->getMergeType() == MergeType::INSTEAD) {
            $result = $subject->getLayout()->createBlock(
                \Magexperts\AutoRelatedProduct\Block\RelatedProductList::class
            )->setData('rule', $rule)->getItems();
        }

        return $result;
    }
}
