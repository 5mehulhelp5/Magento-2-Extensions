<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\AutoRelatedProduct\Block\Adminhtml\Rule;

use Magexperts\Community\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DuplicateButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array|string
     */
    public function getButtonData()
    {
        $data = [];

        if (!$this->authorization->isAllowed("Magexperts_AutoRelatedProduct::rule")) {
            return $data;
        }

        if ($this->getObjectId()) {
            $data = [
                'label' => __('Duplicate (Plus)'),
                'class' => 'duplicate',
                'on_click' => '(typeof versionsManager !== "undefined" && versionsManager._currentPlan == "Basic") ? versionsManager.showAlert("Plus or Extra") : window.location=\'' . $this->getDuplicateUrl() . '\'',
                'sort_order' => 40,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDuplicateUrl()
    {
        return $this->getUrl('mfautorp/*/duplicate', ['id' => $this->getObjectId()]);
    }
}
