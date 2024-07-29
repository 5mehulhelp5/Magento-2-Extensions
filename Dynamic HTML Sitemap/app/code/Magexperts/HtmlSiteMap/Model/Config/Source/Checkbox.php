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
namespace Magexperts\HtmlSiteMap\Model\Config\Source;

/**
 * Class Checkbox
 * @package Magexperts\HtmlSiteMap\Model\Config\Source
 */
class Checkbox extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    public $pageFactory;

    /**
     * @var \Magento\Cms\Model\Page
     */
    public $page;

    /**
     * Checkbox constructor.
     * @param \Magento\Cms\Model\Page $page
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     */
    public function __construct(
        \Magento\Cms\Model\Page $page,
        \Magento\Cms\Model\PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->page = $page;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $this->getStoreId();
        $cms = [];
        $page = $this->pageFactory->create();
        foreach ($page->getCollection() as $item) {
            $cms[$item->getId()] = $item->getTitle();
        }

        $cmsArray = [];
        $count = 0;
        foreach ($cms as $id => $title) {
            $cmsArray[$count]['value'] = $id;
            $cmsArray[$count]['label'] = $title;
            $count++;
        }
        return $cmsArray;
    }
}
