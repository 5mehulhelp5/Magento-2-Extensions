<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Core
 */


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
