<?php
/**
 * Copyright © Magexperts. All rights reserved.
 */

namespace Magexperts\DeleteOrders\Block\Adminhtml\Rules\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;

/**
 * Class DeleteButton
 *
 * Delete button details
 */
class DeleteButton implements ButtonProviderInterface
{
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    private $request;

    /**
     * DeleteButton constructor.
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        $this->request = $context->getRequest();
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * Get button data
     *
     * @return array
     */
    public function getButtonData()
    {
        $data      = [];
        $ruleId = $this->getRuleId();
        if ($ruleId) {
            $data = [
                'label'      => __('Delete'),
                'class'      => 'delete',
                'on_click'   => 'deleteConfirm(\'' .
                    __('Are you sure you want to delete the rule?') .
                    '\', \'' .
                    $this->urlBuilder->getUrl('deleteorders/rules/delete', ['entity_id' => $ruleId]) . '\')',
                'sort_order' => 20
            ];
        }

        return $data;
    }

    /**
     * Get rule id
     *
     * @return mixed|null
     */
    public function getRuleId()
    {
        if ($this->request->getParam('entity_id')) {
            return $this->request->getParam('entity_id');
        } else {
            return null;
        }
    }

    /**
     * Get url
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return  $this->urlBuilder->getUrl($route, $params);
    }
}
