<?php

namespace Magexperts\Easypathhints\Logger;

use Magento\Framework\Logger\Handler\Base;

/**
 * @category   Magexperts
 * @package    Magexperts_Easypathhints
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    http://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Handler extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/Magexperts_easypathhints.log';

    /**
     * @var int
     */
    protected $loggerType = \Monolog\Logger::INFO;
}