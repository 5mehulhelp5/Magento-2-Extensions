<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Core
 */


namespace Magexperts\Core\Components\Ui\Component\Listing\Column;

use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Convert\DataObject;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;

class CustomerGroups extends Column
{
    /**
     * @var array
     */
    private $customerGroups;

    /**
     * @var DataObject
     */
    private $objectConverter;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        GroupRepositoryInterface $groupRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        DataObject $objectConverter,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->objectConverter = $objectConverter;
        $this->customerGroups = $groupRepository->getList($searchCriteriaBuilder->create())->getItems();
    }

    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        $groups = $this->objectConverter->toOptionHash($this->customerGroups, 'id', 'code');
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                $groupNames = [];
                foreach ($item[$fieldName] as $groupId) {
                    if (!isset($groups[$groupId])) {
                        continue;
                    }
                    $groupNames[] = $groups[$groupId];
                }
                $item[$fieldName] = implode(', ', $groupNames);
            }
        }
        return $dataSource;
    }
}
