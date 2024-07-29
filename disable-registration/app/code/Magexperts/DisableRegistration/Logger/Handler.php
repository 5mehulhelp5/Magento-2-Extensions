<?php

namespace Magexperts\DisableRegistration\Logger;

use Magento\Framework\Logger\Handler\Base;

/**
 * @category   Magexperts
 * @package    Magexperts_DisableRegistration
 * @author     Raj KB <Magexperts@gmail.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Handler extends Base
{
    /**
     * @var string
     */
    protected $fileName = '/var/log/Magexperts_disableregistration.log';

    /**
     * @var int
     */
    protected $loggerType = \Monolog\Logger::INFO;
}
