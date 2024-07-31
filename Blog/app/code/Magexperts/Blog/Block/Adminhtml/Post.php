<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml;

/**
 * Admin blog post
 */
class Post extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_post';
        $this->_blockGroup = 'Magexperts_Blog';
        $this->_headerText = __('Post');
        $this->_addButtonLabel = __('Add New Post');

        parent::_construct();
        if (!$this->_authorization->isAllowed("Magexperts_Blog::post_save")) {
            $this->removeButton('add');
        }
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        if ($this->_authorization->isAllowed("Magexperts_Blog::import")) {
            $onClick = "setLocation('" . $this->getUrl('*/import') . "')";

            $this->getToolbar()->addChild(
                'options_button',
                \Magento\Backend\Block\Widget\Button::class,
                ['label' => __('Import Posts'), 'onclick' => $onClick]
            );
        }
        return parent::_prepareLayout();
    }
}
