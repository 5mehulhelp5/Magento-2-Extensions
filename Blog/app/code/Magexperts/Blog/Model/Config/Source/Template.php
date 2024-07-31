<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magexperts\Blog\Model\Config\Source;

use Magexperts\Blog\Model\TemplatePool;

class Template implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var TemplatePool
     */
    private $templatePool;

    /**
     * @var string
     */
    private $templateType;

    /**
     * @var array
     */
    private $options;

    /**
     * Template constructor.
     * @param TemplatePool $templatePool
     * @param string $templateType
     */
    public function __construct(
        TemplatePool $templatePool,
        string $templateType
    ) {
        $this->templatePool = $templatePool;
        $this->templateType = $templateType;
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function toOptionArray():array
    {
        if (!$this->templateType) {
            return[];
        }
        if (!isset($this->options[$this->templateType])) {
            $this->options[$this->templateType] = [];
            foreach ($this->templatePool->getAll($this->templateType) as $value => $info) {
                $this->options[$this->templateType][] = ['value' => $info['value'], 'label' => $info['label']];
            }
        }
        return $this->options[$this->templateType];
    }
}
