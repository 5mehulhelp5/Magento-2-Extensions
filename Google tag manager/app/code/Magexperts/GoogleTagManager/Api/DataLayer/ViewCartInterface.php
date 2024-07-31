<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Api\DataLayer;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Model\Quote;

interface ViewCartInterface
{
    /**
     * Get GTM datalayer
     *
     * @param Quote $quote
     * @return array
     * @throws NoSuchEntityException
     */
    public function get(Quote $quote): array;
}
