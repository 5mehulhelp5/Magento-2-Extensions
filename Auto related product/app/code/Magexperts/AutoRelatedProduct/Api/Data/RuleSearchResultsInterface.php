<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\AutoRelatedProduct\Api\Data;

/**
 * Interface RuleSearchResultsInterface
 */
interface RuleSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Rule list.
     * @return \Magexperts\AutoRelatedProduct\Api\Data\RuleInterface[]
     */
    public function getItems();

    /**
     * Set id list.
     * @param \Magexperts\AutoRelatedProduct\Api\Data\RuleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}