<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Model\Config\Source;

/**
 * Used in recent post widget & post edit page
 *
 */
class Tag implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magexperts\Blog\Model\ResourceModel\Tag\CollectionFactory
     */
    protected $tagCollectionFactory;

    /**
     * @var array
     */
    protected $options;

    /**
     * Initialize dependencies.
     *
     * @param \Magexperts\Blog\Model\ResourceModel\Tag\CollectionFactory $authorCollectionFactory
     * @param void
     */
    public function __construct(
        \Magexperts\Blog\Model\ResourceModel\Tag\CollectionFactory $tagCollectionFactory
    ) {
        $this->tagCollectionFactory = $tagCollectionFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options === null) {
            $this->options = [];
            $collection = $this->tagCollectionFactory->create();
            $collection->setOrder('title');

            foreach ($collection as $item) {
                $this->options[] = [
                    'label' => $item->getTitle(),
                    'value' => $item->getId(),
                ];
            }
        }

        return $this->options;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }
        return $array;
    }
}
