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
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * Magexperts does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Magexperts does not provide extension support in case of
 * incorrect edition usage.
 * =================================================================
 *
 * @category   Magexperts
 * @package    Magexperts_CustomProductAttributeExport
 * @author     Extension Team
 * @copyright  Copyright (c) 2015-2016 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\CustomProductAttributeExport\Model\Rewrite\CatalogImportExport\Export;

class Product extends \Magento\CatalogImportExport\Model\Export\Product
{
    /**
     * Set header columns
     *
     * @param array $customOptionsData
     * @param array $stockItemRows
     */
    protected function setHeaderColumns($customOptionsData, $stockItemRows)
    {
        $config = \Magento\Framework\App\ObjectManager::getInstance()
               ->get('Magento\Framework\App\Config\ScopeConfigInterface');
        $moduleEnabled = (bool)$config->getValue('customproductattributeexport/configuration/enable');
        $merge = [];
        if ($moduleEnabled) {
            $attr = $config->getValue('customproductattributeexport/configuration/allowedattribute');
            $merge = explode(',', $attr);
        }

        if (!$this->_headerColumns) {
            $customOptCols = [
                'custom_options',
            ];
            $this->_headerColumns = array_merge(
                [
                    self::COL_SKU,
                    self::COL_STORE,
                    self::COL_ATTR_SET,
                    self::COL_TYPE,
                    self::COL_CATEGORY,
                    self::COL_PRODUCT_WEBSITES,
                ],
                $this->_getExportMainAttrCodes(),
                $merge,
                [self::COL_ADDITIONAL_ATTRIBUTES],
                reset($stockItemRows) ? array_keys(end($stockItemRows)) : [],
                [],
                [
                    'related_skus',
                    'related_position',
                    'crosssell_skus',
                    'crosssell_position',
                    'upsell_skus',
                    'upsell_position'
                ],
                ['additional_images', 'additional_image_labels', 'hide_from_product_page']
            );
            // have we merge custom options columns
            if ($customOptionsData) {
                $this->_headerColumns = array_merge($this->_headerColumns, $customOptCols);
            }
        }
    }
}
