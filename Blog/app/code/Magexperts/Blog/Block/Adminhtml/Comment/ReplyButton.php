<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml\Comment;

use Magexperts\Community\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class Reply Button Block
 */
class ReplyButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reply'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'reply',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/addreply/',['id' => $this->getObjectId()]);
    }
}