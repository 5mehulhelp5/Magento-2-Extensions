<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Controller\Adminhtml\Category;

/**
 * Blog category save controller
 */
class Save extends \Magexperts\Blog\Controller\Adminhtml\Category
{
    /**
     * @var string
     */
    protected $_allowedKey = 'Magexperts_Blog::category_save';

    /**
     * After model save
     * @param  \Magexperts\Blog\Model\Category $model
     * @param  \Magento\Framework\App\Request\Http $request
     * @return void
     */
    protected function _afterSave($model, $request)
    {
        $model->addData(
            [
                'parent_id' => $model->getParentId(),
                'level' => $model->getLevel(),
            ]
        );
    }

    /**
     * Filter request params
     * @param  array $data
     * @return array
     */
    protected function filterParams($data)
    {
        /* Prepare dates */
        $dateFilter = $this->_objectManager->create(\Magento\Framework\Stdlib\DateTime\Filter\Date::class);

        $filterRules = [];
        foreach (['custom_theme_from', 'custom_theme_to'] as $dateField) {
            if (!empty($data[$dateField])) {
                $filterRules[$dateField] = $dateFilter;
            }
        }

        $inputFilter = $this->getFilterInput(
            $filterRules,
            [],
            $data
        );

        $data = $inputFilter->getUnescaped();

        return $data;
    }
}
