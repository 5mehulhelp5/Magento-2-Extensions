<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Core
 */


namespace Magexperts\Core\Components\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

abstract class LinkedFieldResource extends AbstractDb
{
    /**
     * @var array
     */
    protected $linkedFields = [];

    /**
     * Order is important. Key is required. For example:
     * ["store_labels" => ["magexperts_shipping_carrier_labels", "label", "store_id"]
     *
     * @return array
     */
    protected function getLinkedFields()
    {
        return $this->linkedFields;
    }

    /**
     * @inheritDoc
     */
    protected function _afterSave(AbstractModel $object)
    {
        parent::_afterSave($object);
        foreach (array_keys($this->getLinkedFields()) as $linkedField) {
            $this->updateLinkedField($object, $linkedField);
        }

        return $this;
    }

    /**
     * @param AbstractModel $object
     */
    public function loadAllLinkedData(AbstractModel $object)
    {
        foreach (array_keys($this->getLinkedFields()) as $linkedField) {
            $this->loadLinkedValue($object, $linkedField);
        }
    }

    /**
     * @param AbstractModel $object
     * @param string $linkedField
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function loadLinkedValue(AbstractModel $object, $linkedField)
    {
        list($linkedTable, $valueField, $keyField) = array_values($this->linkedFields[$linkedField]);
        $fetchingValues = [$valueField];
        if ($keyField) {
            array_unshift($fetchingValues, $keyField);
        }


        $select = $this->getConnection()->select()
            ->from($this->getTable($linkedTable), $fetchingValues)
            ->where($this->getIdFieldName() . ' = :id');
        if ($keyField) {
            $linkedData = $this->getConnection()->fetchPairs($select, [':id' => $object->getId()]);
        } else {
            $linkedData = $this->getConnection()->fetchCol($select, [':id' => $object->getId()]);
        }

        $object->setData($linkedField, $linkedData);
    }

    /**
     * @param AbstractModel $object
     * @param string $linkedField
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function updateLinkedField(AbstractModel $object, $linkedField)
    {
        list($linkedTable, $valueField, $keyField) = array_values($this->linkedFields[$linkedField]);
        $idField = $this->getIdFieldName();
        $linkedTable = $this->getTable($linkedTable);
        $connection = $this->getConnection();

        if ($object->hasData($linkedField)) {
            $connection->delete($linkedTable, $connection->quoteInto("$idField = ?", $object->getId()));
        }

        $data = [];
        foreach ((array)$object->getData($linkedField) as $key => $value) {
            if ($value !== null) {
                $new = [
                    $idField => $object->getId(),
                    $valueField => $value,
                ];
                if (!empty($keyField)) {
                    $new[$keyField] = $key;
                }
                $data[] = $new;
            }
        }

        if ($data) {
            $connection->insertMultiple($this->getTable($linkedTable), $data);
        }

        return $this;
    }
}