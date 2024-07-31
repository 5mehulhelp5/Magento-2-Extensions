<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml\Grid\Column\Render;

/**
 * Author column renderer
 */
class Author extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @var \Magexperts\Blog\Api\AuthorInterfaceFactory
     */
    protected $authorFactory;

    /**
     * @var array
     */
    protected static $authors = [];

    /**
     * Author constructor.
     * @param \Magento\Backend\Block\Context $context
     * @param \Magexperts\Blog\Api\AuthorInterfaceFactory $authorFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magexperts\Blog\Api\AuthorInterfaceFactory $authorFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->authorFactory = $authorFactory;
    }

    /**
     * Render author grid column
     *
     * @param   \Magento\Framework\DataObject $row
     * @return  string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        if ($id = $row->getData($this->getColumn()->getIndex())) {
            $title = $this->getAuthorById($id)->getTitle();
            if ($title) {
                return $title;
            }
        }
        return null;
    }

    /**
     * Retrieve author by id
     *
     * @param   int $id
     * @return  \Magexperts\Blog\Model\Author
     */
    protected function getAuthorById($id)
    {
        if (!isset(self::$authors[$id])) {
            self::$authors[$id] = $this->authorFactory->create()->load($id);
        }
        return self::$authors[$id];
    }
}
