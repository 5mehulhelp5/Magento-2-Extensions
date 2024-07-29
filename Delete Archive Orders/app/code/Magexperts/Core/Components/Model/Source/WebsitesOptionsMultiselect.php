<?php

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
