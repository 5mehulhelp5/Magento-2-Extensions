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
namespace Magexperts\CustomProductAttributeExport\Model\Config\Source;

class Allowedattribute implements \Magento\Framework\Option\ArrayInterface
{
    protected $exportMainAttrCodes = [
        'sku',
        'attribute_set',
        'type',
        'product_websites',
        'category_ids',
        'store',
        'name',
        'description',
        'short_description',
        'weight',
        'product_online',
        'tax_class_name',
        'visibility',
        'price',
        'special_price',
        'special_price_from_date',
        'special_price_to_date',
        'url_key',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'base_image',
        'base_image_label',
        'small_image',
        'small_image_label',
        'thumbnail_image',
        'thumbnail_image_label',
        'swatch_image',
        'swatch_image_label',
        'created_at',
        'updated_at',
        'new_from_date',
        'new_to_date',
        'display_product_options_in',
        'map_price',
        'msrp_price',
        'map_enabled',
        'special_price_from_date',
        'special_price_to_date',
        'gift_message_available',
        'custom_design',
        'custom_design_from',
        'custom_design_to',
        'custom_layout_update',
        'page_layout',
        'product_options_container',
        'msrp_price',
        'msrp_display_actual_price_type',
        'map_enabled',
        'country_of_manufacture',
        'map_price',
        'display_product_options_in',
        'related_skus',
        'related_position',
        'crosssell_skus',
        'crosssell_position',
        'upsell_skus',
        'upsell_position',
        'additional_images',
        'additional_image_labels',
        'hide_from_product_page',
        'custom_layout',
        'gallery',
        'has_options',
        'image',
        'image_lable',
        'links_exist',
        'links_purchased_separately',
        'links_title',
        'media_gallery',
        'meta_keyword',
        'minimal_price',
        'msrp',
        'news_from_date',
        'news_to_date',
        'old_id',
        'options_container',
        'price_type',
        'price_view',
        'quantity_and_stock_status',
        'required_options',
        'samples_title',
        'shipment_type',
        'sku_type',
        'special_from_date',
        'special_to_date',
        'status',
        'tax_class_id',
        'thumbnail',
        'thumbnail_label',
        'tier_price',
        'url_path',
        'image_label',
        'weight_type'
    ];

    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection
     */
    private $coll;

    /**
     * @var \Magento\Eav\Model\ConfigFactory
     */
    private $configFactory;

    /**
     * Allowedattribute constructor.
     *
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection $coll
     * @param \Magento\Eav\Model\ConfigFactory $configFactory
     */
    public function __construct(
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection $coll,
        \Magento\Eav\Model\ConfigFactory $configFactory
    ) {
        $this->coll = $coll;
        $this->configFactory = $configFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $entityTypeId = $this->configFactory->create()
            ->getEntityType(\Magento\Catalog\Api\Data\ProductAttributeInterface::ENTITY_TYPE_CODE)
            ->getEntityTypeId();
        $this->coll->addFieldToFilter(\Magento\Eav\Model\Entity\Attribute\Set::KEY_ENTITY_TYPE_ID, $entityTypeId);
        $attrAll = $this->coll->load()->getItems();
        $array = [];
        foreach ($attrAll as $attribute) {
            if ((!in_array($attribute['attribute_code'], $this->exportMainAttrCodes)) &&
                ($attribute->getIsSystem() == 0)
            ) {
                $array[] = [
                    'value' => $attribute["attribute_code"],
                    'label' => $attribute["frontend_label"] . ' ('. $attribute["attribute_code"].')'
                ];
            }
        }
        return  $array;
    }

    /**
     * Get options in 'key-value' format
     *
     * @return array
     */
    public function toArray()
    {
        $options = $this->toOptionArray();
        $return = [];

        foreach ($options as $option) {
            $return[$option['value']] = $option['label'];
        }

        return $return;
    }
}
