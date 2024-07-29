<?php

namespace Magexperts\StorePricing\Model\Preference\Catalog\Product\Attribute\Backend;

use \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

/**
 * @category Magexperts
 * @package Magexperts_StorePricing
 * @author Raj KB <Magexperts@gmail.com>
 * @website https://www.Magexperts.com
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Enddate extends \Magento\Eav\Model\Entity\Attribute\Backend\Datetime
{
    public function setAttribute($attribute)
    {
        parent::setAttribute($attribute);
        $this->setScope($attribute);
        return $this;
    }

    public function setScope($attribute)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $helper = $objectManager->create(\Magexperts\StorePricing\Helper\Data::class);
        if ($helper->isActive()
            && $helper->isPriceStoreScope()
            && $attribute->getAttributeCode() == 'special_to_date'
        ) {
            $attribute->setIsGlobal(ScopedAttributeInterface::SCOPE_STORE);
        }

        return $this;
    }
}
