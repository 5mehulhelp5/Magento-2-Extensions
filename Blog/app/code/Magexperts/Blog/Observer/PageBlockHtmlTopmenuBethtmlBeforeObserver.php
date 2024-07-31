<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Blog observer
 */
class PageBlockHtmlTopmenuBethtmlBeforeObserver implements ObserverInterface
{
    /**
     * @var \Magexperts\Blog\Helper\Menu
     */
    protected $menuHelper;

    /**
     * @param \Magexperts\Blog\Helper\Menu $menuHelper
     */
    public function __construct(
        \Magexperts\Blog\Helper\Menu $menuHelper
    ) {
        $this->menuHelper = $menuHelper;
    }

    /**
     * Page block html topmenu gethtml before
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Framework\Data\Tree\Node $menu */
        $menu = $observer->getMenu();
        $tree = $menu->getTree();

        $blogNode = $this->menuHelper->getBlogNode($menu, $menu->getTree());
        if ($blogNode) {
            $menu->addChild($blogNode);
        }
    }
}
