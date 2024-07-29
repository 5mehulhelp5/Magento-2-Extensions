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

namespace Magexperts\RefundRequest\Block\Adminhtml\Label\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * Tabs constructor.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('label_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('EDIT OPTION'));
    }
}
