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
 * @package    Magexperts_DisableCompare
 * @author     Extension Team
 * @copyright  Copyright (c) 2016-2017 Magexperts Co. ( http://magexperts.com )
 * @license    http://magexperts.com/Magexperts-License.txt
 */
namespace Magexperts\DisableCompare\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(
            'disable_compare/general/enable',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
