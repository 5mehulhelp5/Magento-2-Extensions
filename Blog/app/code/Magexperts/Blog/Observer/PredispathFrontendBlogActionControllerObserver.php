<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */
namespace Magexperts\Blog\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magexperts\Blog\Model\Config;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magexperts\Blog\Model\NoSlashUrlRedirect;
use Magexperts\Blog\Model\SlashUrlRedirect;

/**
 * Class Predispath Frontend Blog Action Controller Observer
 */
class PredispathFrontendBlogActionControllerObserver implements ObserverInterface
{
    /**
     * @var NoSlashUrlRedirect
     */
    protected $noSlashUrlRedirect;

    /**
     * @var SlashUrlRedirect
     */
    protected $slashUrlRedirect;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * PredispathFrontendBlogActionControllerObserver constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param NoSlashUrlRedirect $noSlashUrlRedirect
     * @param SlashUrlRedirect $slashUrlRedirect
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        NoSlashUrlRedirect $noSlashUrlRedirect,
        SlashUrlRedirect $slashUrlRedirect = null
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->noSlashUrlRedirect = $noSlashUrlRedirect;
        $this->slashUrlRedirect = $slashUrlRedirect ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magexperts\Blog\Model\SlashUrlRedirect::class);
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $advancedPermalinkEnabled =  $this->scopeConfig->getValue(
            Config::XML_PATH_ADVANCED_PERMALINK_ENABLED,
            ScopeInterface::SCOPE_STORE
        );

        if ($advancedPermalinkEnabled) {
            $redirectToNoSlash = $this->scopeConfig->getValue(
                Config::XML_PATH_REDIRECT_TO_NO_SLASH_BLOG_PLUS,
                ScopeInterface::SCOPE_STORE
            );
        } else {
            $redirectToNoSlash = $this->scopeConfig->getValue(
                Config::XML_PATH_REDIRECT_TO_NO_SLASH,
                ScopeInterface::SCOPE_STORE
            );
        }

        if ($redirectToNoSlash) {
            $this->noSlashUrlRedirect->execute($observer);
        } else {
            $this->slashUrlRedirect->execute($observer);
        }
    }
}
