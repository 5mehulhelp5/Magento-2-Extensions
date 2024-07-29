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
 * @package   Magexperts_FacebookPixel
 * @author    Extension Team
 * @copyright Copyright (c) 2018-2019 Magexperts Co. ( http://magexperts.com )
 * @license   http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\FacebookPixel\Observer;

use Magento\Framework\Event\ObserverInterface;

class Register implements ObserverInterface
{

    /**
     * @var \Magexperts\FacebookPixel\Model\SessionFactory
     */
    protected $fbPixelSession;

    /**
     * @var \Magexperts\FacebookPixel\Helper\Data
     */
    protected $fbPixelHelper;

    /**
     * Register constructor.
     * @param \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession
     * @param \Magexperts\FacebookPixel\Helper\Data $helper
     */
    public function __construct(
        \Magexperts\FacebookPixel\Model\SessionFactory $fbPixelSession,
        \Magexperts\FacebookPixel\Helper\Data $helper
    ) {
        $this->fbPixelSession = $fbPixelSession;
        $this->fbPixelHelper  = $helper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return boolean
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        if (!$this->fbPixelHelper->isRegistration()
            || !$customer
        ) {
            return true;
        }
        $data = [
            'customer_id' => $customer->getId(),
            'email' => $customer->getEmail(),
            'fn' => $customer->getFirstName(),
            'ln' => $customer->getLastName()
        ];

        $this->fbPixelSession->create()->setRegister($data);

        return true;
    }
}
