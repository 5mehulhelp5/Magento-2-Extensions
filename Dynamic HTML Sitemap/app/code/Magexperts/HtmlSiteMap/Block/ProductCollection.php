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
 * @package    MAGEXPERTS_HtmlSiteMap
 * @author     Extension Team
 * @copyright  Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\HtmlSiteMap\Block;

/**
 * Class ProductCollection
 * @package Magexperts\HtmlSiteMap\Block
 */
class ProductCollection extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    public $productCollectionFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    public $scopeConfig;

    /**
     * @var $helper
     */
    public $helper;

    /**
     * ItemsCollection constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
     * @param \Magexperts\HtmlSiteMap\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magexperts\HtmlSiteMap\Helper\Data $helper,
        array $data = []
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->helper = $helper;
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return \Magexperts\HtmlSiteMap\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductCollection()
    {
        $maxProducts = $this->helper->getMaxProduct();
        $maxProducts = (int)$maxProducts;
        if ($maxProducts >= 0 && $maxProducts != null) {
            if ($maxProducts > 50000) {
                $maxProducts = 50000;
            }
        } else {
            $maxProducts = 50000;
        }

        $sortProduct = $this->helper->getSortProduct();
        $orderProduct = $this->helper->getOrderProduct();

        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');

        $collection->addAttributeToFilter('visibility', \Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH);
        $rulerStatus = \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED;

        $collection
            ->addAttributeToFilter('status', $rulerStatus)
            ->addFieldToFilter('excluded_html_sitemap', [
                ['null' => true],
                ['eq' => ''],
                ['eq' => 'NO FIELD'],
                ['eq' => '0'],
            ]);

        $collection->addWebsiteFilter();
        $collection->addUrlRewrite();
        $collection->addAttributeToSort($sortProduct, $orderProduct);
        $collection->setPageSize($maxProducts);
        return $collection;
    }
}
