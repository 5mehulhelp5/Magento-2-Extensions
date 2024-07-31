<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Sidebar;

/**
 * Blog sidebar categories block
 */
class Search extends \Magento\Framework\View\Element\Template
{
    use Widget;

    /**
     * @var \Magexperts\Blog\Model\Url
     */
    protected $_url;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magexperts\Blog\Model\Url $url
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magexperts\Blog\Model\Url $url,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_url = $url;
    }

    /**
     * @var string
     */
    protected $_widgetKey = 'search';

    /**
     * Retrieve query
     * @return string
     */
    public function getQuery()
    {
        return urldecode($this->getRequest()->getParam('q', ''));
    }

    /**
     * Retrieve serch form action url
     * @return string
     */
    public function getFormUrl()
    {
        return $this->_url->getUrl('', \Magexperts\Blog\Model\Url::CONTROLLER_SEARCH);
    }
}
