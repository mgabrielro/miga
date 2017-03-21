<?php

namespace Common\Log;

use Monolog\Formatter;

/**
 * Class to format log message for logstash
 *
 * @package Common\Log
 * @author Lars Kneschke <lars.kneschke@check24.de>
 */
class C24LogstashFormatter extends Formatter\NormalizerFormatter
{
    /**
     * Category
     *
     * @var string
     */
    protected $category;

    /**
     * Application name
     *
     * @var string
     */
    protected $app_name;

    /**
     * The node name
     *
     * @var string
     */
    protected $node;

    /**
     * @param string $category The category
     * @param string $app_name The app name
     */
    public function __construct($category, $app_name)
    {

        // logstash requires a ISO 8601 format date with optional millisecond precision.
        parent::__construct('Y-m-d\TH:i:s.uP');

        $this->category = $category;
        $this->app_name = $app_name;

        $uname = (function_exists("posix_uname") ? posix_uname(): array());

        if (!empty($uname['nodename'])) {
            $this->node = $uname['nodename'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        $record = parent::format($record);

        // Create object holding all data for logstash
        $object = new \stdClass();
        $object->{'@timestamp'} = gmdate('Y-m-d\TH:i:s\Z');
        $object->remote = (get_remote_addr() !== NULL ? get_remote_addr() : 'localhost');
        $object->local = (isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : 'localhost');
        $object->category = $record['level_name'];
        $object->app_name = $this->app_name;
        $object->host = (!empty($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : php_uname('n'));
        $object->pid = (function_exists("posix_getpid")) ? posix_getpid(): null;
        $object->node = $this->node;
        $object->message = $record['message'];
        $object->environment = \classes\config::get('environment');

        // add all data added by processors
        foreach ($record['extra'] as $key => $value) {
            $object->$key = $value;
        }

        // return json formatted object
        return $this->toJson($object) . "\n";
    }
}
