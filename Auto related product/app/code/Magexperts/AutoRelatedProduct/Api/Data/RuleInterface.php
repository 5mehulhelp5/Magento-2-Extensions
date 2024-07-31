<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\AutoRelatedProduct\Api\Data;

/**
 * Interface RuleInterface
 * @package Magexperts\AutoRelatedProduct\Api\Data
 */
interface RuleInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const ID = 'id';
    const RULE_ID = 'id';

    /**
     * Get customer group id's
     * @return string|null
     */
    public function getStoreIds();

    /**
     * Set customer group id's
     * @param string
     * @return mixed
     */
    public function setStoreIds($storeIds);

    /**
     * Set rule_id
     * @param string $ruleId
     * @return \Magexperts\AutoRelatedProduct\Api\Data\RuleInterface
     */
    public function setRuleId($ruleId);

    /**
     * Get id
     * @return string|null
     */
    public function getId();

    /**
     * Set id
     * @param string $id
     * @return \Magexperts\AutoRelatedProduct\Api\Data\RuleInterface
     */
    public function setId($id);

    /**
     * Get name
     * @return string|null
     */
    public function getName();

    /**
     * Set name
     * @param string
     * @return mixed
     */
    public function setName($name);
}
