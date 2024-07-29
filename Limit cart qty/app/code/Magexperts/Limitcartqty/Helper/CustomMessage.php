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
 * @category  Magexperts
 * @package   Magexperts_Limitcartqty
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\Limitcartqty\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class CustomMessage
 *
 * @package Magexperts\Limitcartqty\Helper
 */
class CustomMessage
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var
     */
    protected $storeId;

    /**
     * CustomMessage constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * Replace Data
     *
     * @param string $text
     * @param string $conf
     * @param string $cart
     * @return mixed
     */
    public function replaceData($text, $conf, $cart)
    {
        $text1 = str_replace("-conf-", $conf, $text);
        $text2 = str_replace("-cart-", $cart, $text1);
        return $text2;
    }

    /**
     * Get Min Message
     *
     * @param string $conf
     * @param string $cart
     * @return Phrase|mixed
     * @throws NoSuchEntityException
     */
    public function getMinMessage($conf, $cart)
    {
        $value = $this->scopeConfig->getValue(
            'Magexperts_Commerce/item_options/Magexperts_min_total_qty_message',
            ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );
        if ($value === null) {
            return __('The fewest you may purchase is %1, you have %2 !', $conf, $cart);
        } else {
            return $this->replaceData($value, $conf, $cart);
        }
    }

    /**
     * GetMaxMessage
     *
     * @param string $conf
     * @param string $cart
     * @return Phrase|mixed
     * @throws NoSuchEntityException
     */
    public function getMaxMessage($conf, $cart)
    {
        $value = $this->scopeConfig->getValue(
            'Magexperts_Commerce/item_options/Magexperts_max_total_qty_message',
            ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );
        if ($value === null) {
            return __('The most you may purchase is %1, you have %2 !', $conf, $cart);
        } else {
            return $this->replaceData($value, $conf, $cart);
        }
    }

    /**
     * GetStoreId
     *
     * @return int
     * @throws NoSuchEntityException
     */
    public function getStoreId()
    {
        if ($this->storeId === null) {
            $this->storeId = $this->storeManager->getStore()->getId();
        }
        return $this->storeId;
    }
}
