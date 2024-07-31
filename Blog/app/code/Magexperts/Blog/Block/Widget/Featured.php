<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Widget;

/**
 * Blog featured posts widget
 */

class Featured extends \Magexperts\Blog\Block\Sidebar\Featured implements \Magento\Widget\Block\BlockInterface
{

    /**
     * Set blog template
     *
     * @return this
     */
    public function _toHtml()
    {
        $this->setTemplate(
            $this->getData('custom_template') ?: 'Magexperts_Blog::widget/recent.phtml'
        );

        return \Magento\Framework\View\Element\Template::_toHtml();
    }

    /**
     * Retrieve block title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getData('title') ?: '';
    }

    /**
     * Retrieve post ids string
     *
     * @return string
     */
    protected function getPostIdsConfigValue()
    {
        return (string)$this->getData('posts_ids');
    }

    /**
     * Retrieve post short content
     *
     * @param  \Magexperts\Blog\Model\Post $post
     * @param  mixed $len
     * @param  mixed $endCharacters
     * @return string
     */
    public function getShorContent($post, $len = null, $endCharacters = null)
    {
        return $post->getShortFilteredContent($len, $endCharacters);
    }

    /**
     * Get relevant path to template
     * Skip parent one as it use template for sidebar block
     *
     * @return string
     */
    public function getTemplate()
    {
        return \Magexperts\Blog\Block\Post\PostList\AbstractList::getTemplate();
    }
}
