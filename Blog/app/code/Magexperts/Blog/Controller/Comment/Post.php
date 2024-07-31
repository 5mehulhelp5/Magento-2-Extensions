<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Magexperts\Blog\Controller\Comment;

/**
 * Blog comment post
 */
class Post extends \Magexperts\Blog\App\Action\Action
{
    /**
     * Customer session model
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * Comment model factory
     *
     * @var \Magexperts\Blog\Model\CommentFactory
     */
    protected $commentFactory;

    /**
     * Post model factory
     *
     * @var \Magexperts\Blog\Model\PostFactory
     */
    protected $postFactory;

    /**
     * Core form key validator
     *
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magexperts\Blog\Model\CommentFactory $commentFactory
     * @param\Magexperts\Blog\Model\PostFactory $postFactory,
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magexperts\Blog\Model\CommentFactory $commentFactory,
        \Magexperts\Blog\Model\PostFactory $postFactory,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
    ) {
        $this->customerSession = $customerSession;
        $this->commentFactory = $commentFactory;
        $this->postFactory = $postFactory;
        $this->formKeyValidator = $formKeyValidator;

        parent::__construct($context);
    }

    /**
     * View blog homepage action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $request = $this->getRequest();

        if (!$this->formKeyValidator->validate($request)) {
            $this->getResponse()->setRedirect(
                $this->_redirect->getRefererUrl()
            );
            return;
        }

        if (!$this->moduleEnabled()) {
            return $this->_forwardNoroute();
        }

        $comment = $this->commentFactory->create();
        $comment->setData($request->getPostValue());

        if ($this->customerSession->getCustomerGroupId()) {
            /* Customer */
            $comment->setCustomerId(
                $this->customerSession->getCustomerId()
            )->setAuthorNickname(
                $this->customerSession->getCustomer()->getName()
            )->setAuthorEmail(
                $this->customerSession->getCustomer()->getEmail()
            )->setAuthorType(
                \Magexperts\Blog\Model\Config\Source\AuthorType::CUSTOMER
            );
        } elseif ($this->getConfigValue(
            \Magexperts\Blog\Helper\Config::GUEST_COMMENT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        )) {
            /* Guest can post review */
            if (!trim($request->getParam('author_nickname')) || !trim($request->getParam('author_email'))) {
                $this->getResponse()->setBody(json_encode([
                    'success' => false,
                    'message' => __('Please enter your name and email'),
                ]));
                return;
            }
            
            $comment->setCustomerId(0)->setAuthorType(
                \Magexperts\Blog\Model\Config\Source\AuthorType::GUEST
            );
        } else {
            /* Guest cannot post review */
            $this->getResponse()->setBody(json_encode([
                'success' => false,
                'message' => __('Login to submit comment'),
            ]));
            return;
        }

        /* Unset sensitive data */
        foreach (['comment_id', 'creation_time', 'update_time', 'status'] as $key) {
            $comment->unsetData($key);
        }

        /* Set default status */
        $comment->setStatus(
            $this->getConfigValue(
                \Magexperts\Blog\Helper\Config::COMMENT_STATUS,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            )
        );

        try {
            $post = $this->initPost();
            if (!$post) {
                throw new \Exception(__('You cannot post comment. Blog post is not longer exist.'), 1);
            }

            if ($request->getParam('parent_id')) {
                $parentComment = $this->initParentComment();
                if (!$parentComment) {
                    throw new \Exception(__('You cannot reply to this comment. Comment is not longer exist.'), 1);
                }

                if (!$parentComment->getPost()
                    || $parentComment->getPost()->getId() != $post->getId()
                    || $parentComment->isReply()
                ) {
                    throw new \Exception(__('You cannot reply to this comment.'), 1);
                }

                $comment->setParentId($parentComment->getId());
            }

            $comment->save();
        } catch (\Exception $e) {
            $this->getResponse()->setBody(json_encode([
                'success' => false,
                'message' => $e->getMessage(),
            ]));
            return;
        }

        $this->getResponse()->setBody(json_encode([
            'success' => true,
            'message' => ($comment->getStatus() == \Magexperts\Blog\Model\Config\Source\CommentStatus::PENDING)
                ? __('You submitted your comment for moderation.')
                : __('Thank you for your comment.')
        ]));
    }

    /**
     * Initialize and check post
     *
     * @return \Magexperts\Blog\Model\Post|bool
     */
    protected function initPost()
    {
        $postId = (int)$this->getRequest()->getParam('post_id');
        $post = $this->postFactory->create()->load($postId);
        if (!$post->getIsActive()) {
            return false;
        }
        return $post;
    }

    /**
     * Initialize and check parent comment
     *
     * @return \Magexperts\Blog\Model\Comment|bool
     */
    protected function initParentComment()
    {
        $commentId = (int)$this->getRequest()->getParam('parent_id');

        $comment = $this->commentFactory->create()->load($commentId);
        if (!$comment->isActive()) {
            return false;
        }

        return $comment;
    }
}
