<?php

namespace Magexperts\Core\Plugin\Notifications;

use Magento\AdminNotification\Block\ToolbarEntry as NativeToolbarEntry;

class MagexpertsNotificationLogoAddInToolbar
{
    /**
     * @param NativeToolbarEntry $subject
     * @param $html
     * @return mixed
     */
    public function afterToHtml(
        NativeToolbarEntry $subject,
        $html
    ) {
        return $this->getReplacedLogoWithHtml($subject, $html);
    }

    /**
     * @param NativeToolbarEntry $subject
     * @return \Magento\AdminNotification\Model\ResourceModel\Inbox\Collection
     */
    private function getMagexpertsNotificationsCollection(NativeToolbarEntry $subject)
    {
        return $subject->getLatestUnreadNotifications()
            ->clear()
            ->addFieldToFilter(\Magexperts\Core\Api\ColumnInterface::AITOC_NOTIFICATION_FIELD, 1);
    }

    /**
     * @param NativeToolbarEntry $subject
     * @param $html
     * @return mixed
     */
    private function getReplacedLogoWithHtml(NativeToolbarEntry $subject, $html)
    {
        foreach ($this->getMagexpertsNotificationsCollection($subject) as $item) {
            $search = 'data-notification-id="' . $item->getId() . '"';
            $html = str_replace($search, $search . ' data-aitcore-logo="1"', $html);
        }

        return $html;
    }
}
