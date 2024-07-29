<?php

namespace Magexperts\StorePricing\Plugin\Model\Catalog\Config\Source\Price;

use Magexperts\StorePricing\Helper\Data as StorePricingHelper;
use Magexperts\StorePricing\Model\Config;

/**
 * @category   Magexperts
 * @package    Magexperts_StorePricing
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    http://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Scope
{
    /**
     * @var StorePricingHelper
     */
    protected $storePricingHelper;

    public function __construct(
        StorePricingHelper $storePricingHelper
    ) {
        $this->storePricingHelper = $storePricingHelper;
    }

    public function afterToOptionArray(
        \Magento\Catalog\Model\Config\Source\Price\Scope $subject,
        $result
    ) {
        $result[] = [
            'value' => Config::STORE_SCOPE_PRICE_VALUE,
            'label' => __('Store View')
        ];
        return $result;
    }
}
