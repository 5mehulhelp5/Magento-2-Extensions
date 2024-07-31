<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magexperts\Blog\Api;

interface ShortContentExtractorInterface
{
    /**
     * Retrieve short filtered content
     * @param string$content
     * @param mixed $len
     * @param mixed $endCharacters
     * @return string
     * @throws \Exception
     */
    public function execute($content, $len = null, $endCharacters = null);
}
