<?php

namespace Common\Log;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Monolog\Logger;
use Monolog\Handler;
use Monolog\Processor;

/**
 * Class to create instance of logger
 *
 * @package Common\Log
 * @author Lars Kneschke <lars.kneschke@check24.de>
 */
class LogFactory implements FactoryInterface
{

    /**
     * Create logstash logging error
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Logger
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        // c24 config
        $config = $serviceLocator->get("ZendConfig")->check24;

        // create stream handler and attach c24 log stash formatter
        $streamHandler = new Handler\StreamHandler($config->logs_dir . '/common/zf2.log', Logger::DEBUG);
        $streamHandler->setFormatter(new C24LogstashFormatter('common', 'pkv-mobile-check24'));

        // list of log processors
        $handlers = [
            $streamHandler
        ];

        // list of log processors
        $processors = [
            new \Common\Log\ExceptionProcessor()
        ];

        // add more expensive logging features for development environment only (if configured)
        if ($config->environment === 'development' &&
            $config->log_in_browser_console === true
        ) {
            $handlers[] = new Handler\BrowserConsoleHandler(Logger::DEBUG);
            $processors[] = new Processor\IntrospectionProcessor(Logger::DEBUG);
        }

        return new Logger('logstash', $handlers, $processors);

    }
}