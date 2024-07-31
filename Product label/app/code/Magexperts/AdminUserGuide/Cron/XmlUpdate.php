<?php
/**
 * Copyright © Magexperts (support@magexperts.com). All rights reserved.
 * Please visit Magexperts.com for license details (https://magexperts.com/end-user-license-agreement).
 */
namespace Magexperts\AdminUserGuide\Cron;

use Magexperts\AdminUserGuide\Model\XmlReader;

/**
 * Class XmlReader
 */
class XmlUpdate
{
    /**
     * @var XmlReader
     */
    private $xmlReader;

    /**
     * @param XmlReader $xmlReader
     */
    public function __construct(
        XmlReader $xmlReader
    ) {
        $this->xmlReader = $xmlReader;
    }

    /**
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function execute()
    {
        $this->xmlReader->update();
    }
}
