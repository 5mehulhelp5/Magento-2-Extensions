<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Ui\DataProvider\Form;

use Magexperts\DeleteOrders\Model\ResourceModel\Rules\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * Class RulesEditDataProvider
 *
 * Rules data provider
 */
class RulesEditDataProvider extends AbstractDataProvider
{
    /**
     * @var AssetRepository
     */
    protected $assetRepository;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * RulesEditDataProvider constructor.
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $rulesCollectionFactory
     * @param RequestInterface $request
     * @param AssetRepository $assetRepository
     * @param DataPersistorInterface $dataPersistor
     * @param StoreManagerInterface $storeManager
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $rulesCollectionFactory,
        RequestInterface $request,
        AssetRepository $assetRepository,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $rulesCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->assetRepository = $assetRepository;
        $this->request = $request;
        $this->storeManager = $storeManager;

        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        if (!empty($items)) {
            foreach ($items as $item) {
                $this->loadedData[$item->getEntityId()] = $item->getData();
                $this->loadedData[$item->getEntityId()]["order_statuses"] = explode(",", $item->getOrderStatues());
            }
        }
        return $this->loadedData;
    }
}
