<?php

namespace Magexperts\GoToCatalog\Controller\Redirect;

/**
 * @category   Magexperts
 * @package    Magexperts_GoToCatalog
 * @author     Raj KB <info@Magexperts.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class BySku extends \Magexperts\GoToCatalog\Controller\Redirect
{
    public function execute()
    {
        $sku = $this->getRequest()->getParam('sku');
        if (!strlen($sku)) {
            $this->performRedirection($this->goToCatalogHelper->getBaseUrl());
        }

        if ($redirectUrl = $this->productUrlResolver->getUrlBySku($sku)) {
            $this->performRedirection($redirectUrl, 301);
        }

        $this->performRedirection($this->productUrlResolver->getDefaultUrl($sku));
    }

    private function performRedirection($url, $code = 302)
    {
        $this->getResponse()->setRedirect($url, $code)->sendResponse();
    }
}
