<?php

namespace Magexperts\SeoSuite\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magexperts\SeoSuite\Model\ResourceModel\Catalog\CategoryFactory;
use Magexperts\SeoSuite\Model\ResourceModel\Catalog\ProductFactory;
use Magexperts\SeoSuite\Model\ResourceModel\Cms\PageFactory;
use Magexperts\SeoSuite\Helper\Data as SeoSuiteHelper;

/**
 * @category   Magexperts
 * @package    Magexperts_SeoSuite
 * @author     Raj KB <rajkb@Magexperts.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Sitemap extends Template
{
    /**
     * @var SeoSuiteHelper
     */
    private $seoSuiteHelper;

    /**
     * @var ProductFactory
     */
    private $productFactory;

    /**
     * @var CategoryFactory
     */
    private $categoryFactory;

    /**
     * @var PageFactory
     */
    private $pageFactory;

    public function __construct(
        Context $context,
        SeoSuiteHelper $seoSuiteHelper,
        CategoryFactory $categoryFactory,
        ProductFactory $productFactory,
        PageFactory $pageFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->seoSuiteHelper = $seoSuiteHelper;
        $this->categoryFactory = $categoryFactory;
        $this->productFactory = $productFactory;
        $this->pageFactory = $pageFactory;
    }

    public function renderLinkElement($link, $title)
    {
        return '<li><a href="' . $link . '">' . __($title) . '</a></li>';
    }

    public function renderSection($section, $title, $collection)
    {
        $html = '';
        $html .= '<div class="row-sitemap-' . $section . '">';
        $html .= '<h2>' . __($title) . '</h2>';
        if ($collection) {
            $html .= '<ul class="mp-seosuite-sitemap-listing">';
            foreach ($collection as $item) {
                $html .= $this->renderLinkElement($this->getSitemapUrl($item->getUrl()), $item->getTitle());
            }
        }
        $html .= '</ul>';
        $html .= '</div>';
        return $html;
    }

    public function getSitemapUrl($url)
    {
        return $this->getBaseUrl() . ltrim($url, '/');
    }

    public function getHtmlSitemap()
    {
        $storeId = $this->_storeManager->getStore()->getId();
        $config = $this->seoSuiteHelper->getConfig();
        $htmlSitemap = '';
        $htmlSitemap .= $this->renderSection(
            'product',
            $config->getHtmlSitemapProductLabel(),
            $this->productFactory->create()->getCollection($storeId)
        );
        $htmlSitemap .= $this->renderSection(
            'category',
            $config->getHtmlSitemapCategoryLabel(),
            $this->categoryFactory->create()->getCollection($storeId)
        );
        $htmlSitemap .= $this->renderSection(
            'page',
            $config->getHtmlSitemapCmsPageLabel(),
            $this->pageFactory->create()->getCollection($storeId)
        );
        return $htmlSitemap;
    }
}
