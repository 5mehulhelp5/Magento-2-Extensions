<?php
/**
 * @author Magexperts Team
 * @copyright Copyright (c) 2022 Magexperts (https://www.magexperts.com)
 * @package Magexperts_Smtp
 */


namespace Magexperts\Smtp\Plugin\Framework\Mail\Template;

use Magento\Framework\Exception\MailException;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magexperts\Smtp\Model\Resolver\From;

class TransportBuilder
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
        SenderResolverInterface $SenderResolver
    ) {
        $this->fromResolver = $fromResolver;
        $this->senderResolver = $SenderResolver;
    }

    /**
     * @param \Magento\Framework\Mail\Template\TransportBuilder $subject
     * @param $from
     * @return array
     * @throws MailException
     */
    public function beforeSetFrom(
        \Magento\Framework\Mail\Template\TransportBuilder $subject,
        $from
    ) {
        $this->fromResolver->reset();
        $senderData = $from;

        if (is_string($from)) {
            $senderData = $this->senderResolver->resolve($from);
        }

        if (is_array($from)) {
            $senderData = $from;
        }

        $this->fromResolver->setFrom($senderData);

        return [$from];
    }
}
