<?php

namespace Magexperts\Core\Plugin\Notifications;

class GridActions
{
    const CONFIG_MAGEXPERTS_CORE_SECTION_NAME = 'magexperts_core';

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuilder;

    /**
     * GridActions constructor.
     * @param \Magento\Framework\UrlInterface $urlBuilder
     */
    public function __construct(
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @param NativeActions $subject
     * @param \Closure $proceed
     * @param \Magento\Framework\DataObject $row
     * @return mixed|string
     */
    public function aroundRender(
        \Magento\AdminNotification\Block\Grid\Renderer\Actions $subject,
        \Closure $proceed,
        \Magento\Framework\DataObject $row
    ) {
        $result = $proceed($row);
        if ($row->getData(\Magexperts\Core\Api\ColumnInterface::MAGEXPERTS_NOTIFICATION_FIELD)) {
            $result .= sprintf(
                '<a class="action" href="%s" title="%s">%s</a>',
                $this->getDisableUrl(),
                __('Disable Notifications'),
                __('Disable Notifications')
            );
        }

        return  $result;
    }

    /**
     * @return string
     */
    private function getDisableUrl()
    {
        return $this->urlBuilder->getUrl('adminhtml/system_config/edit/'). 'section/'
            . self::CONFIG_MAGEXPERTS_CORE_SECTION_NAME;
    }
}
