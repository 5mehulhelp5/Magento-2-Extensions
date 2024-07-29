<?php

namespace Magexperts\DisableRegistration\Plugin\Customer\Model;

use Magento\Customer\Model\Registration;
use Magexperts\DisableRegistration\Helper\Data as DisableRegistrationHelper;

/**
 * @category   Magexperts
 * @package    Magexperts_DisableRegistration
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class DisableRegistrationPlugin
{
    /**
     * @var DisableRegistrationHelper
     */
    protected $helper;

    public function __construct(
        DisableRegistrationHelper $helper
    ) {
        $this->helper = $helper;
    }

    public function afterIsAllowed(
        Registration $subject,
        $result
    ) {
        $this->helper->log(__METHOD__, true);
        if ($this->helper->isActive()
            && $this->helper->isRegistrationDisabled()
        ) {
            return false;
        }
        return true;
    }
}
