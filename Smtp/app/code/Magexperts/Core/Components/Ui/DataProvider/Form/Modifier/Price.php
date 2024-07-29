<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Core
 */


namespace Magexperts\Core\Components\Ui\DataProvider\Form\Modifier;

use Magento\Framework\Stdlib\ArrayManager;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class Price implements ModifierInterface
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ArrayManager
     */
    private $arrayManager;

    /**
     * @var string
     */
    private $fieldset;

    /**
     * @var array
     */
    private $priceFields;

    public function __construct(
        StoreManagerInterface $storeManager,
        ArrayManager $arrayManager,
        $fieldset = 'general',
        $priceFields = []
    ) {
        $this->storeManager = $storeManager;
        $this->arrayManager = $arrayManager;
        $this->fieldset = $fieldset;
        $this->priceFields = $priceFields;
    }

    /**
     * @inheritDoc
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function modifyMeta(array $meta)
    {
        return $this->preparePriceFields($meta);

    }

    /**
     * @param $meta
     * @return array
     */
    protected function preparePriceFields($meta)
    {
        $symbol = $this->storeManager->getStore()->getBaseCurrency()->getCurrencySymbol();
        foreach ($this->priceFields as $priceField) {
            $pricePath = $this->fieldset . '/children/' . $priceField . '/arguments/data/config/';
            $meta = $this->arrayManager->set($pricePath . 'addbefore', $meta, $symbol);
//            $meta = $this->arrayManager->set($pricePath . 'validation', $meta, ['validate-zero-or-greater' => true]);
//            $meta = $this->arrayManager->set($pricePath . 'additionalClasses', $meta, ['admin__field-small' => true]);
        }

        return $meta;
    }
}
