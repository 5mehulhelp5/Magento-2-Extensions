<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types = 1);

namespace Magexperts\Crowdin\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;
use Magexperts\Crowdin\Model\GetTranslationEntity;
use Magexperts\Crowdin\Model\Config;

class Magento extends Select
{
    /**
     * @param Context $context
     * @param GetTranslationEntity $translationEntity
     * @param array $data
     */
    public function __construct(
        Context $context,
        GetTranslationEntity $translationEntity,
        Config $config,
        array $data = []
    ) {
        $this->translationEntity = $translationEntity;
        $this->config = $config;
        parent::__construct($context, $data);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {

            //$savedFields = $this->config->getMappedFields();

            $this->addOption(0, ' ');

            foreach ($this->translationEntity->getTranslatableAttributes() as $key => $translatableAttributes) {
                $this->addOption(
                    '',
                    '---- ' . ucfirst($key) . ' ---',
                    ['disabled' => true]
                );

                foreach ($translatableAttributes as $translatableAttribute) {
                    $params = [];
                   // $params = isset($savedFields[$key .'/'. $translatableAttribute['code']]) ? ['disabled' => true] : [];

                    $this->addOption(
                        $key .'/'. $translatableAttribute['code'],
                        ucfirst($key) . ' - ' . $translatableAttribute['label'],
                        $params
                    );
                }
            }
        }

        return parent::_toHtml();
    }
}
