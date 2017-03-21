<?php

namespace Common\Log;

use Monolog\Logger;

/**
 * Class to process exceptions
 *
 * @package Common\Log
 * @author Lars Kneschke <lars.kneschke@check24.de>
 */
class ExceptionProcessor
{
    /**
     * @var int The logging level
     */
    private $level;

    /**
     * @param int $level The logging level
     */
    public function __construct($level = Logger::DEBUG)
    {
        $this->level = Logger::toMonologLevel($level);
    }

    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {

        // return if the level is not high enough
        if ($record['level'] < $this->level) {
            return $record;
        }

        // handle only exceptions
        if (!isset($record['context']['exception'])) {
            return $record;
        }

        /** @var \Exception $exception */
        $exception = $record['context']['exception'];

        // check if $exception is really an exception
        if (!$exception instanceof \Exception) {
            return $record;
        }

        $record['extra']['line'] = $exception->getLine();
        $record['extra']['file'] = $exception->getFile();
        $record['extra']['backtrace'] = $exception->getTraceAsString();
        $record['extra']['code'] = $exception->getCode();
        $record['extra']['exception'] = get_class($exception);

        return $record;
    }
}