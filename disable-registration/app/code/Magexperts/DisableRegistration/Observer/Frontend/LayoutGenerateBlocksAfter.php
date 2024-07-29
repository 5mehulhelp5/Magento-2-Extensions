<?php

namespace Magexperts\DisableRegistration\Observer\Frontend;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magexperts\DisableRegistration\Helper\Data as DisableRegistrationHelper;

/**
 * @category   Magexperts
 * @package    Magexperts_DisableRegistration
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class LayoutGenerateBlocksAfter implements ObserverInterface
{
    const TEMPLATE_FOR_CUSTOMER_NEW          = 'Magexperts_DisableRegistration::customer/newcustomer.phtml';
    const CUSTOMER_LOGIN_PAGE_FULL_ACTION    = 'customer_account_login';

    /**
     * @var DisableRegistrationHelper
     */
    protected $helper;

    public function __construct(
        DisableRegistrationHelper $helper
    ) {
        $this->helper = $helper;
    }

    public function execute(Observer $observer)
    {
        $this->helper->log(__METHOD__, true);
        if (! $this->helper->isActive()
            || ! $this->helper->isRegistrationDisabled()
            || ! $this->helper->showRegistrationDisabledMessage()
        ) {
            return $this;
        }

        $fullActionName = $observer->getFullActionName();

        if (! in_array(
            $fullActionName,
            [
                self::CUSTOMER_LOGIN_PAGE_FULL_ACTION
            ]
        )) {
            return $this;
        }

        $layout = $observer->getLayout();
        if ($customerNewBlock = $layout->getBlock('customer.new')) {
            $customerNewBlock->setTemplate(self::TEMPLATE_FOR_CUSTOMER_NEW);
            $customerNewBlock->setData(
                'mp_registration_disabled_message',
                $this->helper->getConfigHelper()->getRegistrationDisabledMessage()
            );
        }
    }
}
