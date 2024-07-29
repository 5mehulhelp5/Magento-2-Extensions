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
 * @category  Magexperts
 * @package   Magexperts_Limitcartqty
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\Limitcartqty\Block\Adminhtml\Form\Field;

use Magento\CatalogInventory\Block\Adminhtml\Form\Field\Customergroup;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\BlockInterface;

/**
 * Class Maxtotalqty
 *
 * @package Magexperts\Limitcartqty\Block\Adminhtml\Form\Field
 */
class Maxtotalqty extends AbstractFieldArray
{
    /**
     * @var
     */
    protected $groupRenderer;


    /**
     * Get Group
     *
     * @return BlockInterface
     * @throws LocalizedException
     */
    protected function _getGroupRenderer()
    {
        if (!$this->groupRenderer) {
            $this->groupRenderer = $this->getLayout()->createBlock(
                Customergroup::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
            $this->groupRenderer->setClass('customer_group_select');
        }
        return $this->groupRenderer;
    }

    /**
     * Prepare To Render
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'customer_group_id',
            ['label' => __('Customer Group'), 'renderer' => $this->_getGroupRenderer()]
        );
        $this->addColumn('config_value', ['label' => __('Maximum Qty')]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Maximum Qty');
    }

    /**
     * _prepareArrayRow
     */
    protected function _prepareArrayRow(DataObject $row)
    {
        $optionExtraAttr = [];
        $optionExtraAttr['option_' . $this->_getGroupRenderer()->calcOptionHash($row->getData('customer_group_id'))] =
            'selected="selected"';
        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
    }
}
