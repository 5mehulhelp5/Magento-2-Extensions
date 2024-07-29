<?php

namespace Magexperts\ProductAttachment\Logger;

use Magento\Framework\Logger\Handler\Base;

/**
 * @category   Magexperts
 * @package    Magexperts_ProductAttachment
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Handler extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/Magexperts_productattachment.log';

    /**
     * @var int
     */
    protected $loggerType = \Monolog\Logger::INFO;
}
