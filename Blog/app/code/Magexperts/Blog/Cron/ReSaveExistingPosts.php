<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

namespace Magexperts\Blog\Cron;

use Magexperts\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use Magexperts\Blog\Model\Config;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Event\ManagerInterface;

/**
 * ReSave Posts that have PublishTime <= CurrentTime In Order To They Be Visible - Need If FPC Is Enabled
 */
class ReSaveExistingPosts
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var PostCollectionFactory
     */
    private $postCollectionFactory;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var ManagerInterface
     */
    private $eventManager;

    /**
     * @param Config $config
     * @param PostCollectionFactory $postCollectionFactory
     * @param DateTime $date
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        Config $config,
        PostCollectionFactory $postCollectionFactory,
        DateTime $date,
        ManagerInterface $eventManager
    ) {
        $this->config = $config;
        $this->postCollectionFactory = $postCollectionFactory;
        $this->date = $date;
        $this->eventManager = $eventManager;
    }

    /**
     * @return void
     */
    public function execute()
    {
        if (!$this->config->isEnabled()) {
            return;
        }

        $postCollection = $this->postCollectionFactory->create()
            ->addActiveFilter()
            ->addFieldToFilter('publish_time', ['gteq' => $this->date->gmtDate('Y-m-d H:i:s', strtotime('-2 minutes'))])
            ->addFieldToFilter('publish_time', ['lteq' => $this->date->gmtDate()]);

        foreach ($postCollection as $post) {
            $post->setAllIdentifiersFlag(1);
            $this->eventManager->dispatch('clean_cache_by_tags', ['object' => $post]);
        }
    }
}
