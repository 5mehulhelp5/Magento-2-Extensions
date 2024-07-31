<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
declare(strict_types=1);

namespace Magexperts\Crowdin\Api;

/**
 * @api
 * Interface TranslationRepositoryInterface
 */
interface TranslationRepositoryInterface
{
    /**
     * @param string $storeId
     * @return mixed
     */
    public function getEntitiesList(string $storeId);

    /**
     * @param string $id
     * @return mixed
     */
    public function getEntity(string $id);

    /**
     * @param string $id
     * @param string $data
     * @return mixed
     */
    public function updateEntity(string $id, string $data);

    /**
     * @return mixed
     */
    public function getStoresList();
}
