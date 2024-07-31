<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\GoogleTagManager\Block\Adminhtml\System\Config\Form;

class ExportServerContainerButton extends ExportWebContainerButton
{
    /**
     * @var string
     */
    protected $conteinerType = 'server';

    /**
     * @return string
     */
    public function getContainerGenerateUrl()
    {
        return $this->getUrl(
            'mfgoogletagmanagerextra/serverContainer/generate',
            [
                'store_id' => (int)$this->getRequest()->getParam('store') ?: null,
                'website_id' => (int)$this->getRequest()->getParam('website') ?: null
            ]
        );
    }
}
