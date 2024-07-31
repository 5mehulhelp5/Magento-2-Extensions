<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\ProductLabel\Ui\DataProvider\Rule;

use Magexperts\ProductLabel\Model\ResourceModel\Rule\Collection as GridCollection;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Magexperts\ProductLabel\Model\ResourceModel\Rule as ResourceModel;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Class Rule
 */
class Rule extends GridCollection implements SearchResultInterface
{
    protected $aggregations;

    protected function _construct()
    {
        $this->_init(Document::class, ResourceModel::class);
    }

    public function getAggregations()
    {
        return $this->aggregations;
    }

    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    public function getSearchCriteria()
    {
        return null;
    }

    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        return $this;
    }

    public function setItems(array $items = null)
    {
        return $this;
    }
}
