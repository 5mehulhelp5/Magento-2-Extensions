<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Model\Tag;

use Magexperts\Blog\Model\ResourceModel\Tag\CollectionFactory;

/**
 * Provides Data for Tag Autocomplete Ajax Call
 */
class AutocompleteData
{
    /**
     * @var BlogFactory
     */
    protected $collectionFactory;

    /**
     * Post constructor.
     * @param BlogFactory $blogFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param $search
     * @return array
     */
    public function getItems($search)
    {
        $collection = $this->collectionFactory->create();
        $collection
            ->addFieldToFilter(
                ['tag_id', 'title'],
                [
                    ['eq' => $search],
                    ['like' => '%' . $search . '%'],
                ]
            )
            ->setPageSize(15)
        ;

        $result = [];
        foreach ($collection as $item) {
            $result[] = [
                'value' => $item->getTitle(),
                'label' => $item->getTitle()
            ];
        }

        return $result;
    }
}
