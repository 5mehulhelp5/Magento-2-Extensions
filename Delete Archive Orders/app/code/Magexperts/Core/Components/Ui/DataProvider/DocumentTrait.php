<?php

namespace Magexperts\Core\Components\Ui\DataProvider;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Api\AttributeValueFactory;

/**
 * Helping to use a Model in a Grid Collection
 * @see \Magento\Framework\View\Element\UiComponent\DataProvider\Document
 */
trait DocumentTrait
{
    /**
     * Get an attribute value.
     *
     * @param string $attributeCode
     * @return \Magento\Framework\Api\AttributeInterface|null
     */
    public function getCustomAttribute($attributeCode)
    {
        $attributeValueFactory = ObjectManager::getInstance()->get(AttributeValueFactory::class);
        /** @var \Magento\Framework\Api\AttributeInterface $attributeValue */
        $attributeValue = $attributeValueFactory->create();
        $attributeValue->setAttributeCode($attributeCode);
        $attributeValue->setValue($this->getData($attributeCode));
        return $attributeValue;
    }

    /**
     * Set an attribute value for a given attribute code
     *
     * @param string $attributeCode
     * @param mixed $attributeValue
     * @return $this
     */
    public function setCustomAttribute($attributeCode, $attributeValue)
    {
        $this->setData($attributeCode, $attributeValue);
        return $this;
    }

    /**
     * Retrieve custom attributes values.
     *
     * @return \Magento\Framework\Api\AttributeInterface[]|null
     */
    public function getCustomAttributes()
    {
        $output = [];
        $attributeValueFactory = ObjectManager::getInstance()->get(AttributeValueFactory::class);
        foreach ($this->getData() as $key => $value) {
            $attribute = $attributeValueFactory->create();
            $output[] = $attribute->setAttributeCode($key)->setValue($value);
        }
        return $output;
    }

    /**
     * Set array of custom attributes
     *
     * @param \Magento\Framework\Api\AttributeInterface[] $attributes
     * @return $this
     * @throws \LogicException
     */
    public function setCustomAttributes(array $attributes)
    {
        /** @var \Magento\Framework\Api\AttributeInterface $attribute */
        foreach ($attributes as $attribute) {
            $this->setData(
                $attribute->getAttributeCode(),
                $attribute->getValue()
            );
        }
        return $this;
    }
}