<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\AutoRelatedProduct\Api;

use Magento\Framework\View\Element\AbstractBlock;

interface RelatedItemsProcessorInterface
{
    /**
     * @param AbstractBlock $subject
     * @param $result
     * @param $blockPosition
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(AbstractBlock $subject, $result, $blockPosition);
}
