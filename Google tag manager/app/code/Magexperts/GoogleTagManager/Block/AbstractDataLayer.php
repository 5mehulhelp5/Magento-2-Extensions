<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Block;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Context;
use Magexperts\Community\Api\SecureHtmlRendererInterface;
use Magexperts\GoogleTagManager\Model\Config;

abstract class AbstractDataLayer extends AbstractBlock
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var SecureHtmlRendererInterface
     */
    protected $mfSecureRenderer;

    /**
     * @param Context $context
     * @param Config $config
     * @param array $data
     * @param SecureHtmlRendererInterface|null $mfSecureRenderer
     */
    public function __construct(
        Context $context,
        Config $config,
        array $data = [],
        SecureHtmlRendererInterface $mfSecureRenderer = null
    ) {
        $this->config = $config;
        $this->mfSecureRenderer = $mfSecureRenderer ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(SecureHtmlRendererInterface::class);
        parent::__construct($context, $data);
    }

    /**
     * Get GTM datalayer
     *
     * @return array
     */
    abstract protected function getDataLayer(): array;

    /**
     * Init GTM datalayer
     *
     * @return string
     */
    protected function _toHtml(): string
    {
        if ($this->config->isEnabled()) {
            $dataLayer = $this->getDataLayer();
            if ($dataLayer) {
                $json = json_encode($dataLayer);
                $json = str_replace('"getMfGtmCustomerIdentifier()"', 'getMfGtmCustomerIdentifier()', $json);
                $script = '
                    window.dataLayer = window.dataLayer || [];
                    window.dataLayer.push(' . $json . ');
                ';
                return $this->mfSecureRenderer->renderTag('script', ['style' => 'display:none'], $script, false);
            }
        }

        return '';
    }
}
