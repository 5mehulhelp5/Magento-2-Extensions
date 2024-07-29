<?php

namespace Magexperts\Core\Components\Model\Source;

use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Convert\DataObject;

class CustomerGroupsOptions implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var GroupRepositoryInterface
     */
    private $groupRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $criteriaBuilder;

    /**
     * @var DataObject
     */
    private $dataObjectConverter;


    public function __construct(
        GroupRepositoryInterface $groupRepository,
        SearchCriteriaBuilder $criteriaBuilder,
        DataObject $dataObjectConverter
    ) {
        $this->groupRepository = $groupRepository;
        $this->criteriaBuilder = $criteriaBuilder;
        $this->dataObjectConverter = $dataObjectConverter;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $customerGroups = $this->groupRepository->getList($this->criteriaBuilder->create())->getItems();
        return $this->dataObjectConverter->toOptionArray($customerGroups, 'id', 'code');
    }
}
