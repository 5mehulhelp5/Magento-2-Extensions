<?php
/**
 * Copyright © 2016-Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Category;

/**
 * Blog category abstract
 */
abstract class AbstractCategory extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magexperts\Blog\Model\Url
     */
    protected $_url;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Context $context

     * @param \Magento\Framework\Registry $coreRegistry,
     * @param \Magento\Cms\Model\Template\FilterProvider $filterProvider
     * @param \Magexperts\Blog\Model\Url $url
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magexperts\Blog\Model\Url $url,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_coreRegistry = $coreRegistry;
        $this->_filterProvider = $filterProvider;
        $this->_url = $url;
    }

    /**
     * Retrieve category instance
     *
     * @return \Magexperts\Blog\Model\Category
     */
    public function getCategory()
    {
        return $this->_coreRegistry->registry('current_blog_category');
    }

    /**
     * Retrieve post content
     *
     * @return string
     */
    public function getContent()
    {
        $category = $this->getCategory();
        $key = 'filtered_content';
        if (!$category->hasData($key)) {
            $content = $this->_filterProvider->getPageFilter()->filter(
                (string) $category->getContent() ?: ''
            );
            $category->setData($key, $content);
        }
        return $category->getData($key);
    }
}
