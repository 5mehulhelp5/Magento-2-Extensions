<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml;

/**
 * Admin blog tag
 */
class Tag extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_tag';
        $this->_blockGroup = 'Magexperts_Blog';
        $this->_headerText = __('Tag');
        $this->_addButtonLabel = __('Add New Tag');

        parent::_construct();
        if (!$this->_authorization->isAllowed("Magexperts_Blog::tag_save")) {
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
                ['label' => __('Import Tags'), 'onclick' => $onClick]
            );
        }
        return parent::_prepareLayout();
    }
}
