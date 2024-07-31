<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\XmlSitemap\Block\Adminhtml\System\Config\Form;


/**
 * Admin configurations information block
 */
class Info extends \Magexperts\Community\Block\Adminhtml\System\Config\Form\Info
{
    /**
     * Return extension URL
     *
     * @return string
     */
    protected function getModuleUrl()
    {
        return 'https://mage' . 'fan.com/magento-2-xml-sitemap-extension';
    }

    /**
     * Return extension title
     *
     * @return string
     */
    protected function getModuleTitle()
    {
        return 'XML Sitemap Extension';
    }
}

