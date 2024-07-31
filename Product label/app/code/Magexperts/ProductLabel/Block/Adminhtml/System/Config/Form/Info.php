<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\ProductLabel\Block\Adminhtml\System\Config\Form;

/**
 * Class Info
 */
class Info extends \Magexperts\Community\Block\Adminhtml\System\Config\Form\Info
{
    /**
     * Return extension url
     * @return string
     */
    protected function getModuleUrl()
    {
        return 'https://mage' . 'fan.com/magento-2-product-label';
    }

    /**
     * Return extension title
     * @return string
     */
    protected function getModuleTitle()
    {
        return 'Product Label Extension';
    }
}
