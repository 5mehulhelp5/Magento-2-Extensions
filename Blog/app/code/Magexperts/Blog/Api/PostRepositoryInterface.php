<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Api;

use Magexperts\Blog\Model\Post;
use Magexperts\Blog\Model\PostFactory;

/**
 * Interface PostRepositoryInterface
 */
interface PostRepositoryInterface
{
    /**
     * @return PostFactory
     */
    public function getFactory();

    /**
     * @param Post $post
     * @return mixed
     */
    public function save(Post $post);

    /**
     * @param $postId
     * @return mixed
     */
    public function getById($postId);

    /**
     * Retrieve Post matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * @param Post $post
     * @return mixed
     */
    public function delete(Post $post);

    /**
     * Delete Post by ID.
     *
     * @param int $postId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($postId);
}
