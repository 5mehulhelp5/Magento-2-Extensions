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
 * @package    Magexperts_LazyImageLoader
 * @author     Extension Team
 * @copyright  Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\LazyImageLoader\Model\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class LazyImage implements ObserverInterface
{
    /**
     * @var \Magexperts\LazyImageLoader\Helper\Data
     */
    protected $helper;

    public function __construct(
        \Magexperts\LazyImageLoader\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * @param EventObserver $observer
     */
    public function execute(EventObserver $observer)
    {
        $request = $observer->getEvent()->getRequest();

        if ($request->isAjax()) {
            return;
        }
        
        $response = $observer->getEvent()->getResponse();
        if (!$response) {
            return;
        }

        $html = $response->getBody();
        if ($html == '') {
            return;
        }

        if (!$this->helper->isEnabled($html)) {
            return;
        }
        $html = $this->helper->lazyLoad($html);
        $response->setBody($html);
    }
}
