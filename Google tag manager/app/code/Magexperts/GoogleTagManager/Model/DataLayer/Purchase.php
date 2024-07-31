<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Model\DataLayer;

use Magexperts\GoogleTagManager\Api\DataLayer\PurchaseInterface;

class Purchase extends AbstractOrder implements PurchaseInterface
{
    /**
     * @var string
     */
    protected $ecommPageType = 'purchase';

    /**
     * @return string
     */
    protected function getEventName(): string
    {
        return 'purchase';
    }
}
