<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Model\Config\Options;

use Magento\Framework\Option\ArrayInterface;

class Provider implements ArrayInterface
{
    /**
     * @var \Magexperts\Smtp\Model\Providers
     */
    private $providers;

    public function __construct(
        \Magexperts\Smtp\Model\Providers $providers
    ) {
        $this->providers = $providers;
    }

    public function toOptionArray()
    {
        $result = [];

        $result[] = [
            'value' => 'none',
            'label' => 'None'
        ];
        
        foreach ($this->providers->getAllProviders() as $key => $providerData) {
            $result[] = [
                'value' => $key,
                'label' => $providerData['label']
            ];
        }

        return $result;
    }
}
