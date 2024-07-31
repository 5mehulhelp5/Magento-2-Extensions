<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Psr\Log\LoggerInterface;
use Magexperts\GoogleTagManager\Model\Config;
use Magexperts\GoogleTagManager\Api\ContainerInterface as Container;
use Magento\Store\Model\StoreManagerInterface;

class ContainerGenerate extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Magexperts_GoogleTagManager::mfgoogletagmanager_config';

    /**
     * @var RawFactory
     */
    private $resultRawFactory;

    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var RedirectInterface
     */
    private $redirect;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Container
     */
    private $container;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Generate constructor.
     *
     * @param Context $context
     * @param RawFactory $resultRawFactory
     * @param FileFactory $fileFactory
     * @param DateTime $dateTime
     * @param LoggerInterface $logger
     * @param RedirectInterface $redirect
     * @param Config $config
     * @param Container $container
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context               $context,
        RawFactory            $resultRawFactory,
        FileFactory           $fileFactory,
        DateTime              $dateTime,
        LoggerInterface       $logger,
        RedirectInterface     $redirect,
        Config                $config,
        Container             $container,
        StoreManagerInterface $storeManager
    ) {
        $this->resultRawFactory = $resultRawFactory;
        $this->fileFactory = $fileFactory;
        $this->dateTime = $dateTime;
        $this->logger = $logger;
        $this->redirect = $redirect;
        $this->config = $config;
        $this->container = $container;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Generate and download JSON container
     */
    public function execute()
    {
        //clear echo current buffer
        if (function_exists('ob_get_clean')) {
            ob_get_clean();
        }

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        /* Ability to generate JSON file even if the module is disabled.
        if (!$this->config->isEnabled()) {
            $this->messageManager
                ->addErrorMessage(__('To generate a JSON container, please enable the extension first.'));
            return $resultRedirect->setPath($this->redirect->getRefererUrl());
        }
        */

        try {
            $storeId = (string)$this->getRequest()->getParam('store_id') ?: null;
            if (!$storeId && ($websiteId = ((string)$this->getRequest()->getParam('website_id') ?: null))) {
                $storeId = $this->storeManager->getWebsite($websiteId)->getDefaultStore()->getId();
            }

            $container = $this->container->generate($storeId);

            $fileContent = [
                'type' => 'string',
                'value' => json_encode($container, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT),
                'rm' => true
            ];
            return $this->fileFactory->create(
                sprintf('GTM' . '_%s.json', $this->dateTime->date('Y-m-d_H-i-s')),
                $fileContent,
                DirectoryList::MEDIA,
                'application/json'
            );
        } catch (\Exception $e) {
            $this->logger->critical('Error message', ['exception' => $e]);
            $this->messageManager->addErrorMessage(__('Something went wrong while generating the file.'));
            return $resultRedirect->setPath($this->redirect->getRefererUrl());
        }
    }
}
