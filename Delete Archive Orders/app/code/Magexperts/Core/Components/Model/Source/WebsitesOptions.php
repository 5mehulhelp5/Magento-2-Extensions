<?php

namespace Magexperts\Core\Components\Model\Source;

use Magento\Store\Model\System\Store;
use Magento\Framework\Data\OptionSourceInterface;

class WebsitesOptions implements OptionSourceInterface
{
    /**
     * @var Store
     */
    protected $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        return $this->store->getWebsiteValuesForForm();
    }
}
