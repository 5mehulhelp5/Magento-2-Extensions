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
namespace Magexperts\Limitcartqty\Plugin\CustomerData;

use Magexperts\Limitcartqty\Api\DataConfigInterface;
use Magexperts\Limitcartqty\Helper\CheckoutFlag;
use Magexperts\Limitcartqty\Helper\ConfigValue;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Cart
 *
 * @package Magexperts\Limitcartqty\Plugin\CustomerData
 */
class Cart
{

    /**
     * @var CheckoutFlag
     */
    protected $checkoutFlag;
    /**
     * @var DataConfigInterface
     */
    protected $dataConfig;
    /**
     * @var ConfigValue
     */
    protected $helper;

    /**
     * Cart constructor.
     * @param DataConfigInterface $dataConfig
     * @param CheckoutFlag $checkoutFlag
     * @param ConfigValue $helper
     */
    public function __construct(
        DataConfigInterface $dataConfig,
        CheckoutFlag $checkoutFlag,
        ConfigValue $helper
    ) {
        $this->helper = $helper;
        $this->checkoutFlag = $checkoutFlag;
        $this->dataConfig = $dataConfig;
    }

    /**
     * Get Section
     *
     * @param \Magento\Checkout\CustomerData\Cart $subject
     * @param array $result
     * @return mixed
     * @throws NoSuchEntityException
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetSectionData(\Magento\Checkout\CustomerData\Cart $subject, $result)
    {
        if ($this->helper->isModuleEnable() == 1) {
            if ($result['summary_count'] > $this->dataConfig->getMaxValue() ||
                $result['summary_count'] < $this->dataConfig->getMinValue()
            ) {
                $result['possible_onepage_checkout'] = false;
            }
        }
        return $result;
    }
}
