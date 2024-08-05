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
 * @package    Magexperts_StoreviewFlags
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2020 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\StoreviewFlags\Plugin;

use Magexperts\StoreviewFlags\Helper\Data;
use Magento\Backend\Block\System\Store\Grid\Render\Store;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class ShowFlagGrid
 *
 * @package Magexperts\StoreviewFlag\Plugin
 */
class ShowFlagGrid
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * ShowFlagGrid constructor.
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * AroundRender
     *
     * @param Store $subject
     * @param callable $proceed
     * @param DataObject $row
     * @return string|null
     * @throws NoSuchEntityException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function aroundRender(Store $subject, callable $proceed, DataObject $row)
    {
        if (!$this->helper->getEndableModule()) {
            return $proceed($row);
        }

        if (!$row->getData($subject->getColumn()->getIndex())) {
            return null;
        }

        $urlImage = $this->helper->getUrlImageFlag($row->getStoreId());
        if ($urlImage) {
            $urlImage = '<img class="magexperts_flag" src="' . $urlImage . '">';
        }

        return
            $urlImage .
            '<a title="' . __(
                'Edit Store View'
            ) . '"
            href="' .
            $subject->getUrl('adminhtml/*/editStore', ['store_id' => $row->getStoreId()]) .
            '">' .
            $subject->escapeHtml($row->getData($subject->getColumn()->getIndex())) .
            '</a><br />' .
            '(' . __('Code') . ': ' . $row->getStoreCode() . ')';
    }
}
