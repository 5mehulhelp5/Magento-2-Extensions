<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Block\Adminhtml\Post\Tag;

use \Magento\Framework\Registry;
use \Magento\Backend\Block\Template;
use \Magento\Backend\Block\Template\Context;

/**
 * Class Tag Autocomplete Block
 */
class Autocomplete extends Template
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * Autocomplete constructor.
     * @param Context $context
     * @param array $data
     * @param Registry $registry
     */
    public function __construct(Context $context, Registry $registry, array $data = [])
    {
        parent::__construct($context, $data);
        $this->registry = $registry;
    }

    /**
     * @return bool|false|string
     */
    public function getLinkedTags()
    {
        $post = $this->registry->registry('current_model');
        if ($post) {
            $tagsCollection = $post->getRelatedTags();
            $tagsTitles = [];
            foreach ($tagsCollection as $tag) {
                $tagsTitles[] = $tag->getData('title');
            }
            $tagsTitles = array_unique($tagsTitles);
        } else {
            $tagsTitles = [];
        }
        return json_encode($tagsTitles);
    }

    /**
     * @return string
     */
    public function getAutocompleteUrl()
    {
        return $this->getUrl('blog/tag/autocomplete');
    }
}
