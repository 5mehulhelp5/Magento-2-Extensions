<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Api;

use Magexperts\Blog\Model\Comment;
use Magexperts\Blog\Model\CommentFactory;

/**
 * Interface CommentRepositoryInterface
 */
interface CommentRepositoryInterface
{
    /**
     * @return CommentFactory
     */
    public function getFactory();

    /**
     * @param Comment $comment
     * @return mixed
     */
    public function save(Comment $comment);

    /**
     * @param $commentId
     * @return mixed
     */
    public function getById($commentId);

    /**
     * Retrieve Comment matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param Comment $comment
     * @return mixed
     */
    public function delete(Comment $comment);

    /**
     * Delete Comment by ID.
     *
     * @param int $commentId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($commentId);
}
