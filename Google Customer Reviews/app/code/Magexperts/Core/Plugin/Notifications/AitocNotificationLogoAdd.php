<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Core
 */


namespace Magexperts\Core\Plugin\Notifications;

/**
 * Class MagexpertsNotificationLogoAdd
 * @package Magexperts\Core\Plugin\Notifications
 */
class MagexpertsNotificationLogoAdd
{

    /**
     * @param \Magento\AdminNotification\Block\Grid\Renderer\Notice $subject
     * @param \Closure $proceed
     * @param \Magento\Framework\DataObject $row
     * @return mixed|string
     */
    public function aroundRender(
        \Magento\AdminNotification\Block\Grid\Renderer\Notice $subject,
        \Closure $proceed,
        \Magento\Framework\DataObject $row
    ) {
        $result = $proceed($row);

        if ($row->getData(\Magexperts\Core\Api\ColumnInterface::AITOC_NOTIFICATION_FIELD)) {
            return '<div class="magexperts-grid-message"><div class="magexperts-notif-logo"></div>' . $result . '</div>';
        } else {
            return $result;
        }
    }
}
