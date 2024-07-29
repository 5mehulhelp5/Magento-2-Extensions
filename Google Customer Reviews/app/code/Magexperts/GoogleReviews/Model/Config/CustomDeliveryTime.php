<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_GoogleReviews
 */

namespace Magexperts\GoogleReviews\Model\Config;

/**
 * Backend for serialized array data
 *
 * @method mixed string|array getValue()
 */
class CustomDeliveryTime extends \Magento\Framework\App\Config\Value
{
    /** @var \Magexperts\GoogleReviews\Helper\CustomDeliveryTime */
    private $helper;

    protected function _construct()
    {
        parent::_construct();
        $this->helper = $this->getData('helper');
    }

    /**
     * Process data after load
     *
     * @return void
     */
    protected function _afterLoad()
    {
        $value = $this->getValue();
        $value = $this->helper->makeArrayFieldValue($value);
        $this->setValue($value);
    }

    /**
     * Prepare data before save
     *
     * @return void
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        $value = $this->helper->makeStorableArrayFieldValue($value);
        $this->setValue($value);
    }
}
