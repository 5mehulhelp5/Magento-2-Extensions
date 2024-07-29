<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Plugin\Framework\Mail;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Mail\TransportInterfaceFactory as TransportInterfaceFactoryCore;
use Magexperts\Smtp\Model\Config;
use Magexperts\Smtp\Controller\RegistryConstants;

/**
 * TransportInterface Plugin
 */
class TransportInterfaceFactory
{
    /**
     * Object Manager
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var \Magexperts\Smtp\Model\Config
     */
    private $config;


    public function __construct(
        ObjectManagerInterface $objectManager,
        Config $config
    ) {
        $this->objectManager = $objectManager;
        $this->config = $config;
    }

    /**
     * Create Class instance with Specified Parameters
     *
     * @param $subject TransportInterfaceFactoryCore
     * @param $proceed \Callable
     * @param array $data
     * @return \Magento\Framework\Mail\TransportInterface
     */
    public function aroundCreate($subject, $proceed, array $data = [])
    {
        if ($this->config->enabled()) {
            if ($data && isset($data[\Magexperts\Smtp\Controller\RegistryConstants::IS_TEST_FIELD_ARRAY])) {
                unset($data[RegistryConstants::IS_TEST_FIELD_ARRAY]);
                $config = $data;
                $data['message'] = $this->objectManager->create(\Magento\Framework\Mail\Message::class);
            } else {
                $config = $this->config->getFullConfig();
            }

            $data = array_merge($data, ['config' => $config]);

            return $this->objectManager
                ->create(
                    \Magexperts\Smtp\Model\Framework\Mail\Transport::class,
                    $data
                );
        }

        return $proceed($data);
    }
}
