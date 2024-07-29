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
namespace Magexperts\LoginAsCustomer\Plugin\Adminhtml\Grid;

/**
 * Class CustomerActions
 *
 * @package Magexperts\LoginAsCustomer\Plugin\Adminhtml\Grid
 */
class CustomerActions
{

    /**
     * @var \Magento\Framework\View\Element\UiComponent\ContextInterface
     */
    protected $context;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magexperts\LoginAsCustomer\Helper\Data
     */
    protected $dataHelper;

    /**
     * @var \Magento\Framework\AuthorizationInterface
     */
    protected $authorization;
    /**
     * @var \Magento\Backend\Model\Session
     */
    private $session;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * CustomerActions constructor.
     *
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Magexperts\LoginAsCustomer\Helper\Data $dataHelper
     * @param \Magento\Framework\AuthorizationInterface $authorization
     * @param \Magento\Backend\Model\Session $session
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magexperts\LoginAsCustomer\Helper\Data $dataHelper,
        \Magento\Framework\AuthorizationInterface $authorization,
        \Magento\Backend\Model\Session $session
    ) {
        $this->context = $context;
        $this->urlBuilder = $urlBuilder;
        $this->dataHelper = $dataHelper;
        $this->authorization = $authorization;
        $this->session = $session;
    }

    /**
     * Prepare data source
     *
     * @param \Magento\Customer\Ui\Component\Listing\Column\Actions $subject
     * @param array $dataSource
     * @return array
     */
    public function afterPrepareDataSource(
        \Magento\Customer\Ui\Component\Listing\Column\Actions $subject,
        array $dataSource
    ) {
        if (isset($dataSource['data']['items'])) {
            if ($this->dataHelper->isEnable() && $this->dataHelper->getCustomerGridLoginColumn() == 'actions'
                && $this->authorization->isAllowed('Magexperts_LoginAsCustomer::login_button')) {
                foreach ($dataSource['data']['items'] as &$item) {
                    $item[$subject->getData('name')] = $this->prepareItem($item, 'preview');
                }
            } else {
                foreach ($dataSource['data']['items'] as &$item) {
                    $item[$subject->getData('name')] = $this->prepareItem($item);
                }
            }
        }

        return $dataSource;
    }

    /**
     * Get data
     *
     * @param array $item
     * @param mixed $type
     * @return string
     */
    protected function prepareItem($item, $type = null)
    {
        if ($type == 'preview') {
            $urlLogin = $this->urlBuilder
                ->getUrl('loginascustomer/customer/login', ['customer_id' => $item['entity_id']]);
            $urlEdit = $this->urlBuilder->getUrl('customer/index/edit', ['id' => $item['entity_id']]);
            $html = '';
            $html .= '<ul style="list-style:none"><li>' .
                '<a onMouseOver="this.style.cursor=&#039;pointer&#039;"
                href="' . $urlEdit . '">' . 'Edit' . '</a></li>';
            $html .= '<li><a onMouseOver="this.style.cursor=&#039;pointer&#039;"
                onclick="window.open(&quot;' . $urlLogin . '&quot;)">' . 'Login' . '</a></li>';
            $html .= '</ul>';
            return $html;
        } else {
            $urlEdit = $this->urlBuilder->getUrl('customer/index/edit', ['id' => $item['entity_id']]);
            return '<a onMouseOver="this.style.cursor=&#039;pointer&#039;"
                href="' . $urlEdit . '">' . 'Edit' . '</a></li>';
        }
    }
}
