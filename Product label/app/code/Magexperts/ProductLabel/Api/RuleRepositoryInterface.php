<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\ProductLabel\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface RuleRepositoryInterface
 */
interface RuleRepositoryInterface
{

    /**
     * Save Rule
     * @param \Magexperts\ProductLabel\Api\Data\RuleInterface $rule
     * @return \Magexperts\ProductLabel\Api\Data\RuleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Magexperts\ProductLabel\Api\Data\RuleInterface $rule
    );

    /**
     * Retrieve Rule
     * @param string $ruleId
     * @return \Magexperts\ProductLabel\Api\Data\RuleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($ruleId);

    /**
     * Retrieve Rule matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magexperts\ProductLabel\Api\Data\RuleSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Rule
     * @param \Magexperts\ProductLabel\Api\Data\RuleInterface $rule
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Magexperts\ProductLabel\Api\Data\RuleInterface $rule
    );

    /**
     * Delete Rule by ID
     * @param string $ruleId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($ruleId);
}