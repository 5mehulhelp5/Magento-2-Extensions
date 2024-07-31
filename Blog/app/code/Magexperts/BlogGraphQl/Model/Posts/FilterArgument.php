<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\BlogGraphQl\Model\Posts;

use Magento\Framework\GraphQl\Query\Resolver\Argument\FieldEntityAttributesInterface;
use Magento\Framework\GraphQl\ConfigInterface;

/**
 * Class FilterArgument
 * @package Magexperts\BlogGraphQl\Model\Posts
 */
class FilterArgument implements FieldEntityAttributesInterface
{
    /** @var ConfigInterface */
    private $config;

    /**
     * FilterArgument constructor.
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }
    /**
     * Get the attributes for an entity
     *
     * @return array
     */
    public function getEntityAttributes(): array
    {
        $fields = [];
        /** @var \Magento\Framework\GraphQl\Config\Element\Field $field */
        foreach ($this->config->getConfigElement('BlogPost')->getFields() as $field) {
            $fields[$field->getName()] = 'String';
        }
        return $fields;
    }
}
