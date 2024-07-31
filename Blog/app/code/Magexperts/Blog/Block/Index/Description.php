<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

declare(strict_types=1);

namespace Magexperts\Blog\Block\Index;

use Magento\Framework\View\Element\Template;

/**
 * Blog index description
 */
class Description extends Template
{
    public function getDescription(): string
    {
        return (string)$this->_scopeConfig->getValue(
            'mfblog/index_page/description',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
