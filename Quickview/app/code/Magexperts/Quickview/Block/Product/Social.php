<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magexperts\Quickview\Block\Product;


/**
 * Product View block
 * @api
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 100.0.2
 */
class Social extends \Magento\Catalog\Block\Product\View
{
    const XML_PATH_QUICKVIEW_REMOVE_PRODUCT_INFOR_MAILTO = 'magexperts_quickview/general/remove_product_info_mailto';

    public function getConfigShowEmail()
    {
        return $this->_scopeConfig->getValue(self::XML_PATH_QUICKVIEW_REMOVE_PRODUCT_INFOR_MAILTO, \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $this->_storeManager->getStore()->getId());
    }
}
