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
 * @package   Magexperts_PreSelectShippingPayment
 * @author    Extension Team
 * @copyright Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\PreSelectShippingPayment\Model;

use Magento\Store\Model\ScopeInterface;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class CompositeConfigProvider
 *
 * @package Magexperts\PreSelectShippingPayment\Model
 */
class CompositeConfigProvider implements ConfigProviderInterface
{
    /**
     * ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        $isEnabledShipping =  $this->scopeConfig->isSetFlag(
            'preselectshippingpayment/shipping/enable',
            ScopeInterface::SCOPE_STORE
        );
        $isEnabledPayment =  $this->scopeConfig->isSetFlag(
            'preselectshippingpayment/payment/enable',
            ScopeInterface::SCOPE_STORE
        );
        $output = [];
        if ($isEnabledShipping) {
            $output['bssAspConfig']['shipping'] = [
                'default' => $this->getShipingConfig('default'),
                'position' => $this->getShipingConfig('position')
            ];
        }
        if ($isEnabledPayment) {
            $output['bssAspConfig']['payment'] = [
                'default' => $this->getPaymentConfig('default'),
                'position' => $this->getPaymentConfig('position')
            ];
        }
        return $output;
    }

    /**
     * Get auto shipping config
     *
     * @param   string $field
     * @return  mixed
     */
    public function getShipingConfig($field)
    {
        return $this->scopeConfig->getValue(
            'preselectshippingpayment/shipping/' . $field,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get auto payment config
     *
     * @param   string $field
     * @return  mixed
     */
    public function getPaymentConfig($field)
    {
        return $this->scopeConfig->getValue(
            'preselectshippingpayment/payment/' . $field,
            ScopeInterface::SCOPE_STORE
        );
    }
}
