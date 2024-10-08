<?php

namespace Magexperts\GoToCatalog\Logger;

/**
 * @category   Magexperts
 * @package    Magexperts_GoToCatalog
 * @author     Raj KB <info@Magexperts.com>
 * @website    https://www.Magexperts.com
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Logger extends \Monolog\Logger
{
    public function customLog($message)
    {
        try {
            if ($message === null) {
                $message = 'NULL';
            }
            if (is_array($message)) {
                $message = \json_encode($message, JSON_PRETTY_PRINT);
            }
            if (is_object($message)) {
                $message = \json_encode($message, JSON_PRETTY_PRINT);
            }
            if (!empty(\json_last_error())) {
                $message = (string)\json_last_error();
            }
            $message = (string)$message;
        } catch (\Exception $e) {
            $message = 'INVALID MESSAGE::' . $e->getMessage();
        }
        $message .= PHP_EOL;
        $this->info($message);
    }
}
