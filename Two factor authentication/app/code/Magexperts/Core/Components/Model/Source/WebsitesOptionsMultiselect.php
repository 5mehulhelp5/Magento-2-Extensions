<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Core
 */


namespace Magexperts\Core\Components\Model\Source;

/**
 * doesn't contain "-- Please Select--" option
 */
class WebsitesOptionsMultiselect extends WebsitesOptions
{
    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return $this->store->getWebsiteValuesForForm(true);
    }
}
