<?php
/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category   Magexperts
 * @package    Magexperts_RefundRequest
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\RefundRequest\Block\Adminhtml\Label;

use \Magento\Backend\Block\Widget;
use \Magento\Backend\Block\Widget\Form\Container;
use \Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry $_coreRegistry
     */
    protected $coreRegistry = null;

    /**
     * Edit constructor.
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        Widget\Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Edit constructor.
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Magexperts_RefundRequest';
        $this->_controller = 'adminhtml_label';
        parent::_construct();
        $this->buttonList->update('save', 'label', __('Save'));
        $this->buttonList->update('delete', 'label', __('Delete'));
    }

    /**
     * @return \Magento\Framework\Phrase|string
     */
    public function getHeaderText()
    {
        if ($this->coreRegistry->registry('magexperts_refundrequest')->getId()) {
            return __(
                "Edit '%1'",
                $this->escapeHtml(
                    $this->coreRegistry->registry('magexperts_refundrequest')->getTitle()
                )
            );
        } else {
            return __('Add New');
        }
    }
}
