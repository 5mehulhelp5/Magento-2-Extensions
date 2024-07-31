<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Api;

use Magexperts\Blog\Model\Tag;
use Magexperts\Blog\Model\TagFactory;

/**
 * Interface TagRepositoryInterface
 */
interface TagRepositoryInterface
{
    /**
     * @return TagFactory
     */
    public function getFactory();

    /**
     * @param Tag $tag
     * @return mixed
     */
    public function save(Tag $tag);

    /**
     * @param $tagId
     * @return mixed
     */
    public function getById($tagId);

    /**
     * Retrieve Tag matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param Tag $tag
     * @return mixed
     */
    public function delete(Tag $tag);

    /**
     * Delete Tag by ID.
     *
     * @param int $tagId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($tagId);
}
