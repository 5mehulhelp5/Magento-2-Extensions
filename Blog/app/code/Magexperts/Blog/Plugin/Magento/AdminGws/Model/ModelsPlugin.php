<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Plugin\Magento\AdminGws\Model;

/**
 * Class ModelsPlugin class
 */
class ModelsPlugin
{
    /**
     * @param $subject
     * @param callable $proceed
     * @param $model
     * @return callable
     */
    public function aroundCmsPageSaveBefore($subject, callable $proceed, $model)
    {
        $isBlogModel = ($model instanceof \Magexperts\Blog\Model\Post
            || $model instanceof \Magexperts\Blog\Model\Category
        );
        if ($isBlogModel) {
            $storeId = $model->getStoreId();
            if ($model->getStoreIds()) {
                $model->setStoreId($model->getStoreIds());
            }
        }

        return $proceed($model);
    }
}
