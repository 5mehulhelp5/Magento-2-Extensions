<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Core
 */


namespace Magexperts\Core\Components\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Store\Model\System\Store;

class StoreOptions implements OptionSourceInterface
{
    /**
     * @var Store
     */
    private $store;

    /**
     * @param Store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return $this->store->getStoreValuesForForm(false, true);
    }
}
