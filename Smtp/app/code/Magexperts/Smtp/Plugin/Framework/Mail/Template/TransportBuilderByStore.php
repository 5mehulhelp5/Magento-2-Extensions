<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Plugin\Framework\Mail\Template;

use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Framework\Mail\Template\TransportBuilderByStore as TransportBuilderByStoreOriginal;
use Magexperts\Smtp\Model\Resolver\From;


class TransportBuilderByStore
{
    /**
     * @var From
     */
    private $fromResolver;

    /**
     * @var SenderResolverInterface
     */
    private $senderResolver;

    public function __construct(
        From $fromResolver,
        SenderResolverInterface $senderResolver
    ) {
        $this->fromResolver = $fromResolver;
        $this->senderResolver = $senderResolver;
    }

    /**
     * @param TransportBuilderByStore $subject
     * @param $from
     * @param $store
     * @return array
     * @throws MailException
     */
    public function beforeSetFromByStore(
        TransportBuilderByStoreOriginal $subject,
        $from,
        $store
    ) {
        $this->fromResolver->reset();
        $this->fromResolver->setFrom($this->senderResolver->resolve($from, $store));

        return [$from, $store];
    }
}
