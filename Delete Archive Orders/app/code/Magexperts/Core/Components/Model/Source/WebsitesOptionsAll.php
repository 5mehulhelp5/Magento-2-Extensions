<?php

namespace Magexperts\Core\Components\Model\Source;

/**
 * includes "All Websites" option
 */
class WebsitesOptionsAll extends WebsitesOptions
{
    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        $options = $this->store->getWebsiteValuesForForm(false, true);
        foreach ($options as &$option) {
            if ($option['value'] === 0) {
                $option['label'] = __('All Websites');
                break;
            }
        }
        return $options;
    }
}
