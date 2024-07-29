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
 * @category   Magexperts
 * @package    Magexperts_Simpledetailconfigurable
 * @author     Extension Team
 * @copyright  Copyright (c) 2017-2022 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\Quickview\Plugin\Catalog\Controller\Product;

use Magento\Framework\App\Action\Context;

class View
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var \Magexperts\Quickview\Helper\Data
     */
    protected $quickViewMagexperts;

    /**
     * View construct.
     *
     * @param Context $context
     * @param \Magexperts\Quickview\Helper\Data $quickViewMagexperts
     */
    public function __construct(
        Context $context,
        \Magexperts\Quickview\Helper\Data $quickViewMagexperts
    ) {
        $this->context = $context;
        $this->quickViewMagexperts = $quickViewMagexperts;
    }

    /**
     * Get url quick view.
     *
     * @param \Magexperts\Simpledetailconfigurable\Plugin\Catalog\Controller\Product\View $subject
     * @param string $result
     * @param \Magento\Catalog\Model\Product|mixed $product
     * @param string $paramRedirect
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetUrlRedirect($subject, $result, $product, $paramRedirect)
    {
        $params = $this->context->getRequest();
        if ($params->getControllerModule() === 'Magexperts_Quickview') {
            return $this->quickViewMagexperts->getUrl() . 'id/' . $product->getId() . $paramRedirect;
        }
        return $result;
    }
}
