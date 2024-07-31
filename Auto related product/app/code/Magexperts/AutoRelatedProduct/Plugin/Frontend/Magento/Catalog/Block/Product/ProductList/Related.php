<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\AutoRelatedProduct\Plugin\Frontend\Magento\Catalog\Block\Product\ProductList;

use Magexperts\AutoRelatedProduct\Api\RelatedItemsProcessorInterface;

class Related
{
    /**
     * @param RelatedItemsProcessorInterface $relatedItemsProcessor
     */
    private $relatedItemsProcessor;

    /**
     * @param RelatedItemsProcessorInterface $relatedItemsProcessor
     */
    public function __construct(
        RelatedItemsProcessorInterface $relatedItemsProcessor
    ) {
        $this->relatedItemsProcessor = $relatedItemsProcessor;
    }

    /**
     * @param $subject
     * @param $result
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterGetItems($subject, $result)
    {
        return $this->relatedItemsProcessor->execute($subject, $result, 'product_into_related');
    }
}
