<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Cron;

use Exception;
use Magexperts\Core\Model\Helpers\Date;
use Magexperts\Smtp\Model\Config;
use Magexperts\Smtp\Model\ResourceModel\Log\CollectionFactory;
use Psr\Log\LoggerInterface;


class Clear
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var Date
     */
    private $date;

    public function __construct(
        LoggerInterface $logger,
        CollectionFactory $collectionFactory,
        Date $date,
        Config $config
    ) {
        $this->logger = $logger;
        $this->date = $date;
        $this->collectionFactory = $collectionFactory;
        $this->config = $config;
    }

    /**
     * @return $this
     */
    public function execute()
    {
        if (!$this->config->enabled()) {
            return $this;
        }

        $cleanDays = $this->config->cleanLogDays();

        if ($cleanDays) {
            $logCollection = $this->collectionFactory->create()
                ->addFieldToFilter('created_at', [
                    'lteq' => $this->date->getCurrentDateBeforeDays($cleanDays)
                ]);

            foreach ($logCollection as $log) {
                try {
                    $log->delete();
                } catch (Exception $e) {
                    $this->logger->critical($e);
                }
            }
        }

        return $this;
    }
}
