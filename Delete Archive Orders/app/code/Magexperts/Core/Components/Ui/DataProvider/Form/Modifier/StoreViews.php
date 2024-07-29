<?php

namespace Magexperts\Core\Components\Ui\DataProvider\Form\Modifier;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class StoreViews implements ModifierInterface
{
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @var ArrayManager
     */
    private $arrayManager;
    /**
     * @var string
     */
    private $fieldset;
    
    /**
     * @var string
     */
    private $field;

    public function __construct(
        StoreRepositoryInterface $storeRepository,
        ArrayManager $arrayManager,
        $field = 'store_labels',
        $fieldset = null
    ) {
        $this->storeRepository = $storeRepository;
        $this->arrayManager = $arrayManager;
        $this->fieldset = $fieldset ?: $field;
        $this->field = $field;
    }

    /**
     * @inheritDoc
     */
    public function modifyData(array $data)
    {
        if (!empty($data[$this->field])) {
            foreach ($data[$this->field] as $id => $label) {
                $data[$this->field . '[' . $id . ']'] = $label;
            }
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function modifyMeta(array $meta)
    {
        $labelConfigs = [];
        foreach ($this->storeRepository->getList() as $store) {
            $storeId = $store->getId();
            if (!$storeId) {
                continue;
            }

            $labelConfigs[$this->field . '[' . $storeId . ']'] = $this->arrayManager->set(
                'arguments/data/config',
                [],
                [
                    'formElement' => Input::NAME,
                    'componentType' => Field::NAME,
                    'label' => $store->getName(),
                    'dataType' => Text::NAME,
                    'dataScope' => $this->field . '[' . $storeId . ']',
                ]
            );
        }

        $meta[$this->fieldset]['children'] = $labelConfigs;
        return $meta;
    }
}
