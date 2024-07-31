<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml\Grid\Column;

/**
 * Admin blog grid categories
 */
class Categories extends \Magento\Backend\Block\Widget\Grid\Column
{
    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->_rendererTypes['category'] = \Magexperts\Blog\Block\Adminhtml\Grid\Column\Render\Category::class;
        $this->_filterTypes['category'] = \Magexperts\Blog\Block\Adminhtml\Grid\Column\Filter\Category::class;
    }
}
