<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Api;

/**
 * Interface AuthorRepositoryInterface
 */
interface AuthorRepositoryInterface
{
    /**
     * @return AuthorInterfaceFactory
     */
    public function getFactory();

    /**
     * @param AuthorInterface $author
     * @return mixed
     */
    public function save(AuthorInterface $author);

    /**
     * @param $authorId
     * @return mixed
     */
    public function getById($authorId);

    /**
     * Retrieve Author matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param AuthorInterface $author
     * @return mixed
     */
    public function delete(AuthorInterface $author);

    /**
     * Delete Author by ID.
     *
     * @param int $authorId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($authorId);
}
