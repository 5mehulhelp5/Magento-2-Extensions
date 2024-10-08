<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Model\Config\Source;

/**
 * Used in recent post widget
 *
 */
class CategoryPath extends CategoryTree
{
    protected function _getOptions($itemId = 0)
    {
        $childs =  $this->_getChilds();
        $options = [];

        if (!$itemId) {
            $options[] = [
                'label' => '',
                'value' => 0,
            ];
        }

        if (isset($childs[$itemId])) {
            foreach ($childs[$itemId] as $item) {
                $data = [
                    'label' => $item->getTitle() .
                        ($item->getIsActive() ? '' : ' ('.__('Disabled').')'),
                    'value' => ($item->getParentIds() ? $item->getPath().'/' : '') . $item->getId(),
                ];
                if (isset($childs[$item->getId()])) {
                    $data['optgroup'] = $this->_getOptions($item->getId());
                }

                $options[] = $data;
            }
        }

        return $options;
    }
}
