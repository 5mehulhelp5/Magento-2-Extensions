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
 * @package    Magexperts_LoginAsCustomer
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2020 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\LoginAsCustomer\Ui\Component\Listing\Column;

use Magexperts\LoginAsCustomer\Helper\Data;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class CustomerActions
 */
class CustomerActions extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $authorization;

    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * CustomerActions constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param AuthorizationInterface $authorization
     * @param Data $dataHelper
     * @param array $components
     * @param array $data
     */
    // @codingStandardsIgnoreStart
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        AuthorizationInterface $authorization,
        Data $dataHelper,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->authorization = $authorization;
        $this->dataHelper = $dataHelper;

        if (!$this->dataHelper->isEnable() || $this->dataHelper->getCustomerGridLoginColumn() == 'actions' ||
            !$this->authorization->isAllowed('Magexperts_LoginAsCustomer::login_button')) {
            unset($data);
            $data = [];
        }

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    // @codingStandardsIgnoreEnd

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }

        return $dataSource;
    }

    /**
     * Get data
     *
     * @param array $item
     * @return string
     */
    protected function prepareItem($item)
    {
        $url = $this->urlBuilder->getUrl('loginascustomer/customer/login', ['customer_id' => $item['entity_id']]);
        return '<a onMouseOver="this.style.cursor=&#039;pointer&#039;" 
            onclick="window.open(&quot;' . $url . '&quot;)">' . 'Login' . '</a>';
    }
}
