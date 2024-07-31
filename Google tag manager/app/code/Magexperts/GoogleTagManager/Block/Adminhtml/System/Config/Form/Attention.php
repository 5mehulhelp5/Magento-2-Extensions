<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Block\Adminhtml\System\Config\Form;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Admin configurations information block
 */
class Attention extends \Magexperts\Community\Block\Adminhtml\System\Config\Form\Info
{

    /**
     * Return info block html
     *
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return '<div style="padding:10px;background-color:#fffbbb;border:1px solid #ddd;margin-bottom:7px;">
            <strong>Attention!</strong> Once you change and save the "Web/Server Container", "Google Analytics 4" or "Google Ads" settings,
            please don\'t forget to scroll down to the "Export Container" section
            and click the "Generate JSON Container & Download File" button to export container data.
            After you save the file, <a target="_blank" title="Create GTM tags" href="https://magexperts.com/blog/add-google-tag-manager-to-magento-2#5-create-gtm-tags">
            import it to your Google Tag Manager container.</a>
        </div>';
    }
}
