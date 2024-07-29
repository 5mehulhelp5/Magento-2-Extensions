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
 * @package   Magexperts_AdminPaymentMethod
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2022 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */

namespace Magexperts\AdminPaymentMethod\Plugin;

/**
 * Class PreSelect
 *
 * @package Magexperts\AdminPaymentMethod\Plugin
 */

class PreSelect
{
    /**
     * @var \Magexperts\AdminPaymentMethod\Model\AdminPaymentMethod
     */
    private $model;

    /**
     * PreSelect constructor
     *
     * @param \Magexperts\AdminPaymentMethod\Model\AdminPaymentMethod $model
     */
    public function __construct(\Magexperts\AdminPaymentMethod\Model\AdminPaymentMethod $model)
    {
        $this->model = $model;
    }

    /**
     * After get select method code
     *
     * @param \Magento\Sales\Block\Adminhtml\Order\Create\Billing\Method\Form $block
     * @param string $result
     * @return bool|string
     */
    public function afterGetSelectedMethodCode(
        \Magento\Sales\Block\Adminhtml\Order\Create\Billing\Method\Form $block,
        $result
    ) {
        if ($result && $result != 'free') {
            return $result;
        }

        $data = $this->model->getDataPreSelect();
        if ($data) {
            return \Magexperts\AdminPaymentMethod\Model\AdminPaymentMethod::CODE;
        }
        return false;
    }
}
