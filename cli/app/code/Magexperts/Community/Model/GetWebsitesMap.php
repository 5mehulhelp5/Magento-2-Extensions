<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\Community\Model;

use Magexperts\Community\Api\GetWebsitesMapInterface;
use Magento\Store\Model\StoreManagerInterface;


class GetWebsitesMap implements GetWebsitesMapInterface
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var
     */
    private $websitesMap;

    /**
     * GetWebsitesMap constructor.
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->storeManager = $storeManager;
    }

    /**
     * @return array
     */
    public function execute(): array
    {
        if ($this->websitesMap === null) {
            $this->websitesMap = [];
            $websites = $this->storeManager->getWebsites();
            foreach ($websites as $website) {
                // Continue if website has no store to be able to create catalog rule for website without store
                if ($website->getDefaultStore() === null) {
                    continue;
                }
                $this->websitesMap[$website->getId()] = $website->getDefaultStore()->getId();
            }
        }

        return $this->websitesMap;
    }
}
