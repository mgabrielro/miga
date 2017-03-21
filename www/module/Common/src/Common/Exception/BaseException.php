<?php

namespace Common\Exception;

use Common\Validator\Check;
use Psr\Log\LoggerInterface;

/**
 * Class BaseException
 *
 * @package Common\Exception
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class BaseException extends \Exception
{
    /**
     * @var LoggerInterface
     */
    protected static $logger = NULL;

    /**
     * Constructor
     *
     * @param string $message Exception message
     * @param boolean $log_message Write message to log file
     * @param integer $code Exception code
     * @param \Exception $previous Previous exception
     * @return void
     */
    public function __construct($message, $log_message = true, $code = 0, \Exception $previous = NULL)
    {
        Check::is_string($message, 'message');
        Check::is_boolean($log_message, 'log_message');
        Check::is_integer($code, 'code', true);

        // Call parent
        parent::__construct($message, $code, $previous);

        // Log exception
        if ($log_message == true && static::$logger instanceof LoggerInterface) {
            static::$logger->error($this->getMessage(), ['exception' => $this]);
        }
    }

    /**
     * Set log manager
     *
     * @param LoggerInterface $logger Log manager
     * @return void
     */
    public static function setLogger(LoggerInterface $logger) {
        static::$logger = $logger;
    }
}