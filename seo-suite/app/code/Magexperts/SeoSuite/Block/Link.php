<?php

namespace Magexperts\SeoSuite\Block;

use Magento\Framework\App\DefaultPathInterface;
use Magento\Framework\View\Element\Template\Context;
use Magexperts\SeoSuite\Helper\Data as SeoSuiteHelper;

/**
 * @category   Magexperts
 * @package    Magexperts_SeoSuite
 * @author     Raj KB <rajkb@Magexperts.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Link extends \Magento\Framework\View\Element\Html\Link\Current
{
    /**
     * @var SeoSuiteHelper
     */
    private $seoSuiteHelper;

    public function __construct(
        Context $context,
        DefaultPathInterface $defaultPath,
        SeoSuiteHelper $seoSuiteHelper,
        array $data = []
    ) {
        parent::__construct($context, $defaultPath, $data);
        $this->seoSuiteHelper = $seoSuiteHelper;
    }

    public function toHtml()
    {
        if (!$this->seoSuiteHelper->getConfig()->isHtmlSitemapEnabled()) {
            return '';
        }
        return parent::toHtml();
    }

    public function getPath()
    {
        return $this->seoSuiteHelper->getBaseUrl() . 'sitemap';
    }

    public function getLabel()
    {
        return $this->seoSuiteHelper->getConfig()->getHtmlSitemapMetaTitle();
    }
}
