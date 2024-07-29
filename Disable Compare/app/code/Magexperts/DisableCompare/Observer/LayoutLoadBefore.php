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
 * @package    Magexperts_DisableCompare
 * @author     Extension Team
 * @copyright  Copyright (c) 2016-2017 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\DisableCompare\Observer;

use Magexperts\DisableCompare\Helper\Data as ModuleHelper;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class LayoutLoadBefore implements ObserverInterface
{
    /**
     * @var ModuleHelper
     */
    private $moduleHelper;

    public function __construct(ModuleHelper $moduleHelper)
    {
        $this->moduleHelper = $moduleHelper;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $disableCompare = $this->moduleHelper->isEnabled();
        if ($disableCompare) {
            $layout = $observer->getData('layout');
            $layout->getUpdate()->addHandle('remove_compare_products');
        }
    }
}
