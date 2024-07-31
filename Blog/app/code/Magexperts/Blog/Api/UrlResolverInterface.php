<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
namespace Magexperts\Blog\Api;

/**
 * Interface UrlResolverInterface
 */
interface UrlResolverInterface
{
    /**
     * @param string $path
     * @return array
     */
    public function resolve($path);
}
