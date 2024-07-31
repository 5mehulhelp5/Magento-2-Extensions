<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types = 1);

namespace Magexperts\Crowdin\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Magexperts\Crowdin\Api\TranslationRepositoryInterface;
use Magexperts\Crowdin\Model\GetTranslationEntitiesList;
use Magexperts\Crowdin\Model\GetTranslationEntity;
use Magexperts\Crowdin\Model\UpdateTranslationEntity;
use Magexperts\Crowdin\Model\Config;
use Magento\Store\Model\StoreManagerInterface;

class TranslationRepository implements TranslationRepositoryInterface
{
    /**
     * @var \Magexperts\Crowdin\Model\GetTranslationEntitiesList
     */
    private $getTranslationEntitiesList;

    /**
     * @var \Magexperts\Crowdin\Model\GetTranslationEntity
     */
    private $getTranslationEntity;

    /**
     * @var \Magexperts\Crowdin\Model\UpdateTranslationEntity
     */
    private $updateTranslationEntity;

    /**
     * @var StoreManagerInterface
     */
    private $_storeManager;

    /**
     * @var \Magexperts\Crowdin\Model\Config
     */
    private $config;

    /**
     * @param \Magexperts\Crowdin\Model\GetTranslationEntitiesList $getTranslationEntitiesList
     * @param \Magexperts\Crowdin\Model\GetTranslationEntity $getTranslationEntity
     * @param \Magexperts\Crowdin\Model\UpdateTranslationEntity $updateTranslationEntity
     * @param StoreManagerInterface $storeManager
     * @param \Magexperts\Crowdin\Model\Config $config
     */
    public function __construct(
        GetTranslationEntitiesList $getTranslationEntitiesList,
        GetTranslationEntity $getTranslationEntity,
        UpdateTranslationEntity $updateTranslationEntity,
        StoreManagerInterface $storeManager,
        Config $config
    ) {
        $this->getTranslationEntitiesList = $getTranslationEntitiesList;
        $this->getTranslationEntity = $getTranslationEntity;
        $this->updateTranslationEntity = $updateTranslationEntity;
        $this->_storeManager = $storeManager;
        $this->config = $config;
    }

    /**
     * @param string $storeId
     * @return mixed
     */
    public function getEntitiesList($storeId)
    {
        if (!$this->config->isEnabled()) {
            return __('Extension doesn\'t enabled!');
        }
        ini_set('max_execution_time', '0');

        return $this->getTranslationEntitiesList->execute($storeId);

    }

    /**
     * @return array
     */
    public function getStoresList()
    {
        if (!$this->config->isEnabled()) {
            return __('Extension doesn\'t enabled!');
        }

        $options = [];

        foreach ($this->_storeManager->getStores() as $key => $value) {
            $options[] = [
                'id' => $value->getId(),
                'name' => $value->getName(),
                'locale' => $this->config->getLocaleByStoreId($value->getId()),
            ];
        }

        return $options;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function getEntity($id)
    {
        if (!$this->config->isEnabled()) {
            return __('Extension doesn\'t enabled!');
        }

        return $this->getTranslationEntity->execute($id);
    }

    /**
     * @param string $id
     * @param string $data
     * @return mixed
     */
    public function updateEntity(string $id, string $data)
    {
        if (!$this->config->isEnabled()) {
            return __('Extension doesn\'t enabled!');
        }

        return $this->updateTranslationEntity->execute($id, $data);
    }
}
