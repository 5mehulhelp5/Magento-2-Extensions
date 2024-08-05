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
 * @package    Magexperts_StoreviewFlags
 * @author     Extension Team
 * @copyright  Copyright (c) 2019-2020 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\StoreviewFlags\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Data
 *
 * @package Magexperts\StoreviewFlags\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Data constructor.
     * @param StoreManagerInterface $storeManager
     * @param Context $context
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Context $context
    ) {
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * GetEndableModule
     *
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getEndableModule()
    {
        return $this->scopeConfig->getValue(
            'magexperts_store_flag/general/enable_module',
            ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );
    }

    /**
     * GetUpload
     *
     * @param number $storeId
     * @return string
     * @throws NoSuchEntityException
     */
    public function getUrlImageFlag($storeId = null)
    {
        $imgUrl = $this->scopeConfig
            ->getValue('magexperts_store_flag/image/uploadflag', ScopeInterface::SCOPE_STORE, $storeId);
        if ($imgUrl != '') {
            return $this->storeManager->getStore($storeId)
                   ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'magexpertsstoresflags/' . $imgUrl;
        }
        return false;
    }

    /**
     * GetStoreId
     *
     * @return int
     * @throws NoSuchEntityException
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

    /**
     * GetHeight
     *
     * @param number $storeId
     * @return mixed
     */
    public function getHeight($storeId = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_store_flag/image/imgheight',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * GetWidth
     *
     * @param number $storeId
     * @return mixed
     */
    public function getWidth($storeId = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_store_flag/image/imgwidth',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Get Storeview Name
     *
     * @param number $storeId
     * @return mixed
     */
    public function getShowStoreviewName($storeId = null)
    {
        return $this->scopeConfig->getValue(
            'magexperts_store_flag/store_name/enable_name',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
