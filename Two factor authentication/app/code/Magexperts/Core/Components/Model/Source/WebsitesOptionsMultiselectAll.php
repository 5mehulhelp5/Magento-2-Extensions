<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Core
 */


namespace Magexperts\Core\Components\Model\Source;

/**
 * includes "All Websites" option
 * doesn't contain "-- Please Select--" option
 */
class WebsitesOptionsMultiselectAll extends WebsitesOptions
{
    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $options = $this->store->getWebsiteValuesForForm(true, true);
        foreach ($options as &$option) {
            if ($option['value'] === 0) {
                $option['label'] = __('All Websites');
                break;
            }
        }
        return $options;
    }
}
