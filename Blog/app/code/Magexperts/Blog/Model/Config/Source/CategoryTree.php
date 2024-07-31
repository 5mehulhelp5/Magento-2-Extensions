<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Model\Config\Source;

/**
 * Used in edit post form
 *
 */
class CategoryTree implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magexperts\Blog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $_categoryCollectionFactory;

    /**
     * @var array
     */
    protected $_options;

    /**
     * @var array
     */
    protected $_childs;

    /**
     * Initialize dependencies.
     *
     * @param \Magexperts\Blog\Model\ResourceModel\Category\CollectionFactory $authorCollectionFactory
     * @param void
     */
    public function __construct(
        \Magexperts\Blog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    ) {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->_options === null) {
            $this->_options = $this->_getOptions();
        }
        return $this->_options;
    }

    protected function _getOptions($itemId = 0)
    {
        $childs =  $this->_getChilds();
        $options = [];

        if (isset($childs[$itemId])) {
            foreach ($childs[$itemId] as $item) {
                $data = [
                    'label' => $item->getTitle() .
                        ($item->getIsActive() ? '' : ' ('.__('Disabled').')'),
                    'value' => $item->getId(),
                ];
                if (isset($childs[$item->getId()])) {
                    $data['optgroup'] = $this->_getOptions($item->getId());
                }

                $options[] = $data;
            }
        }

        return $options;
    }

    protected function _getChilds()
    {
        if ($this->_childs === null) {
            $this->_childs =  $this->_categoryCollectionFactory->create()
                ->getGroupedChilds();
        }
        return $this->_childs;
    }
}
