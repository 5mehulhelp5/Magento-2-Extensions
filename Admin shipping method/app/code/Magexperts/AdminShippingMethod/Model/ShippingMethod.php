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
 * @package   Magexperts_AdminShippingMethod
 * @author    Extension Team
 * @copyright Copyright (c) 2017-2018 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\AdminShippingMethod\Model;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\Method;
use Magento\Shipping\Model\Rate\Result;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\State;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Backend\App\Area\FrontNameResolver;
use Magexperts\AdminShippingMethod\Helper\Data;
use Magento\Framework\App\RequestInterface;

class ShippingMethod extends AbstractCarrier implements CarrierInterface
{
    /**
     * @var string
     */
    protected $_code = 'adminshippingmethod';

    /**
     * @var bool
     */
    protected $_isFixed = true;

    /**
     * @var ResultFactory
     */
    protected $rateResultFactory;

    /**
     * @var MethodFactory
     */
    protected $rateMethodFactory;

    /**
     * @var State
     */
    protected $appState;

    /**
     * @var Data
     */
    protected $help;

    /**
     * @var RequestInterface
     */
    protected $requestInterface;

    /**
     * ShippingMethod constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param State $appState
     * @param Data $help
     * @param RequestInterface $requestInterface
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        State $appState,
        Data $help,
        RequestInterface $requestInterface,
        array $data = []
    ) {
        $this->help = $help;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->appState = $appState;
        $this->requestInterface = $requestInterface;
        parent::__construct(
            $scopeConfig,
            $rateErrorFactory,
            $logger,
            $data
        );
    }

    /**
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function isAdmin()
    {
        if ($this->appState->getAreaCode() === FrontNameResolver::AREA_CODE) {
            return true;
        }
        return false;
    }

    /**
     * @param RateRequest $request
     * @return bool|\Magento\Framework\DataObject|Result|null
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active') || !$this->isAdmin()) {
            return false;
        }

        /** @var Result $result */
        $result = $this->rateResultFactory->create();
        /** @var Method $method */
        $method = $this->rateMethodFactory->create();

        $method->setCarrier('adminshippingmethod');
        $method->setCarrierTitle($this->help->getTitle($this->idStore()));

        $method->setMethod('adminshippingmethod');
        $method->setMethodTitle($this->help->getName($this->idStore()));

        $method->setPrice('0.00');
        $method->setCost('0.00');
        $result->append($method);

        return $result;
    }

    /**
     * @return int
     */
    public function idStore()
    {
        $storeId = (isset($this->requestInterface->getPostValue()['store_id'])) ?
            $this->requestInterface->getPostValue()['store_id'] : $this->getParamStore();
        return $storeId;
    }

    /**
     * @return int
     */
    public function getParamStore()
    {
        $storeId = 0;
        $orderId = $this->requestInterface->getParam('order_id', 0);
        if ($orderId != 0) {
            $order = $this->help->getOrder()->load($orderId);
            $storeId = $order->getStoreId();
        }
        return $storeId;
    }
    /**
     * @return array
     */
    public function getAllowedMethods()
    {
        return ['adminshippingmethod' => $this->help->getName($this->idStore())];
    }

    /**
     * @param \Magento\Framework\DataObject $request
     * @return $this|bool|ShippingMethod|false|\Magento\Framework\Model\AbstractModel|AbstractCarrier
     */
    public function checkAvailableShipCountries(\Magento\Framework\DataObject $request)
    {
        $speCountriesAllow = $this->getConfigData('sallowspecific');
        /*
         * for specific countries, the flag will be 1
         */
        if ($speCountriesAllow && $speCountriesAllow == 1) {
            return $this->checkValue($request);
        }
        return $this;
    }

    /**
     * @param $request
     * @return $this|bool|\Magento\Quote\Model\Quote\Address\RateResult\Error
     *
     */
    public function checkValue($request)
    {
        if (!$this->checkActive()) {
            return false;
        }
        $showMethod = $this->getConfigData('showmethod');
        $availableCountries = $this->getAvaiable();
        if ($availableCountries && in_array($request->getDestCountryId(), $availableCountries)) {
            return $this;
        } elseif ($showMethod
            && (!$availableCountries || $availableCountries
                && !in_array($request->getDestCountryId(), $availableCountries))
        ) {
            /** @var $error */
            $error = $this->_rateErrorFactory->create();
            $error->setCarrier($this->_code);
            $error->setCarrierTitle($this->getConfigData('title'));
            $errorMsg = $this->help->getError($this->idStore());
            $error->setErrorMessage(
                $errorMsg ? $errorMsg : __(
                    'Sorry, but we can\'t deliver to the destination country with this shipping module.'
                )
            );
            return $error;
        } else {
            /*
             * The admin set not to show the shipping module if the delivery country
             * is not within specific countries
             */
            return false;
        }
    }

    /**
     * @return bool
     */
    public function checkActive()
    {
        if (!$this->getConfigFlag('active') || !$this->isAdmin()) {
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getAvaiable()
    {
        $availableCountries = [];
        if ($this->getConfigData('specificcountry')) {
            $availableCountries = explode(',', $this->getConfigData('specificcountry'));
        }
        return $availableCountries;
    }
}
