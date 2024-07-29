<?php
/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category   Magexperts
 * @package    Magexperts_RefundRequest
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\RefundRequest\Ui\Component\Listing\Columns;

use Magento\Framework\Filter\FilterManager;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Class for Order Number
 */
class OrderNumber extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var OrderInterface
     */
    protected $orderInterface;

    /**
     * @var FilterManager
     */
    private $filterManager;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param FilterManager $filterManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        OrderInterface $orderInterface,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        FilterManager $filterManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->orderInterface = $orderInterface;
        $this->filterManager = $filterManager;
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $entityId = $this->getEntityId($item);
                $item['increment_id_url'] = $this->getLink($entityId);
            }
        }
        return $dataSource;
    }

    /**
     * @param $entityId
     * @return string
     */
    private function getLink($entityId)
    {
        return $this->context->getUrl('sales/order/view', ['order_id' => $entityId]);
    }

    /**
     * @param $item
     * @return mixed
     */
    public function getEntityId($item)
    {
        $incrementId = $item['increment_id'];
        $orderData = $this->orderInterface->loadByIncrementId($incrementId)->getEntityId();
        return $orderData;
    }
}
