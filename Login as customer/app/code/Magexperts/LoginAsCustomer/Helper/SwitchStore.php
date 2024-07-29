<?php
/**
 * Magexperts Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://magexperts.com/Magexperts-License.txt
 *
 * @category   Magexperts
 * @package    Magexperts_LoginAsCustomer
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2020 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\LoginAsCustomer\Helper;

use Magento\Framework\App\Action\Context as ActionContext;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Model\StoreIsInactiveException;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\StoreSwitcherInterface;

/**
 * Class SwitcherStore
 *
 * @package Magexperts\LoginAsCustomer\Plugin
 */
class SwitchStore
{
    /**
     * @var StoreSwitcherInterface
     */
    private $storeSwitcher;
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * SwitcherStore constructor.
     * @param StoreSwitcherInterface $storeSwitcher
     * @param StoreRepositoryInterface $storeRepository
     * @param StoreManagerInterface $storeManager
     * @param UrlInterface $url
     * @param ActionContext $context
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        StoreSwitcherInterface $storeSwitcher,
        StoreRepositoryInterface $storeRepository,
        StoreManagerInterface $storeManager,
        UrlInterface $url,
        ActionContext $context
    ) {
        $this->storeSwitcher = $storeSwitcher;
        $this->storeRepository = $storeRepository;
        $this->storeManager = $storeManager;
        $this->url = $url;
        $this->messageManager = $context->getMessageManager();
    }

    /**
     * After Customer Login
     *
     * @param string $url
     * @param string $storecode
     * @param string $notice
     * @return mixed
     * @throws NoSuchEntityException
     * @throws \Magento\Store\Model\StoreSwitcher\CannotSwitchStoreException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function switchStoreView($url, $storecode)
    {
        $error = null;
        $fromStoreStoreCode = $this->storeManager->getStore()->getCode();
        try {
            $fromStore = $this->storeRepository->get($fromStoreStoreCode);
            $targetStore = $this->storeRepository->getActiveStoreByCode($storecode);
        } catch (NoSuchEntityException $e) {
            $error = __("The store that was requested wasn't found. Verify the store and try again.");
        } catch (StoreIsInactiveException $e) {
            $error = __('Requested store is inactive');
        }
        if ($error !== null) {
            $this->messageManager->addErrorMessage($error);
        } else {
            $this->storeSwitcher->switch($fromStore, $targetStore, $url);
            $this->messageManager->getMessages(true);
        }
    }
}
