<?php /** @noinspection ALL */
/** @noinspection PhpUndefinedClassInspection */

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
namespace Magexperts\AdminShippingMethod\Plugin\Sales\Block\Adminhtml\Order\Create\Shipping\Method;

use Magento\Sales\Block\Adminhtml\Order\Create\Shipping\Method\Form;
use Magexperts\AdminShippingMethod\Helper\Data;

class AroundCreateForm
{
    /**
     * @var Data
     */
    protected $helper;
    /**
     * AfterCreateForm constructor.
     * @param Data $helper
     */
    public function __construct(
        Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * @param Form $subject
     * @param $result
     * @return bool
     */
    public function aroundIsMethodActive(Form $subject, callable $proceed, $code)
    {
        $storeId = $subject->getAddress()->getQuote()->getStoreId();
        $selectStore = $this->helper->getPreSelect($storeId);
        $getActive = $subject->getActiveMethodRate();
        if (!$getActive) {
            if ($selectStore) {
                if ($code == "adminshippingmethod_adminshippingmethod") {
                    return true;
                }
            }
        }
        return $proceed($code);
    }
}
