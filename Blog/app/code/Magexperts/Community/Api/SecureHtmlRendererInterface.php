<?php

/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */

declare(strict_types=1);

namespace Magexperts\Community\Api;

interface SecureHtmlRendererInterface
{

    /**
     * @param string $tagName
     * @param array $attributes
     * @param string|null $content
     * @param bool $textContent
     * @return string
     */
    public function renderTag(
        string $tagName,
        array $attributes,
        ?string $content = null,
        bool $textContent = true
    );

}
