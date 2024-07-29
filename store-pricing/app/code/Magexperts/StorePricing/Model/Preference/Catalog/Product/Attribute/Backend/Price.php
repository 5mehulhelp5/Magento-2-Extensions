<?php

namespace Magexperts\StorePricing\Model\Preference\Catalog\Product\Attribute\Backend;

use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

/**
 * @category Magexperts
 * @package Magexperts_StorePricing
 * @author Raj KB <Magexperts@gmail.com>
 * @website https://www.Magexperts.com
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Price extends \Magento\Catalog\Model\Product\Attribute\Backend\Price
{
    public function setScope($attribute)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create(\Magexperts\StorePricing\Helper\Data::class);
        if (! $helper->isActive() || ! $helper->isPriceStoreScope()) {
            return parent::setScope($attribute);
        }

        $attribute->setIsGlobal(ScopedAttributeInterface::SCOPE_STORE);
        return $this;
    }
}
