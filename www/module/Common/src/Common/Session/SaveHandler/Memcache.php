<?php

namespace Common\Session\SaveHandler;

use Zend\Session\SaveHandler\SaveHandlerInterface;

/**
 * Memcache save handler
 *
 * @author Patrick Völk
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class Memcache implements SaveHandlerInterface
{
    /**
     * @var null
     */
    protected $memcached = NULL;

    /**
     * @var array
     */
    protected $memcached_config = [
        'host' => NULL,
        'port' => NULL
    ];

    /**
     * Constructor
     *
     * @param string $host Host
     * @param string $port Port
     * @return void
     */
    public function __construct($host, $port)
    {
        $this->memcached_config['host'] = $host;
        $this->memcached_config['port'] = $port;
    }

    /**
     * Open Session - retrieve resources
     *
     * @param string $save_path
     * @param string $name
     */
    public function open($savePath, $name)
    {
        return true;
    }

    /**
     * Close Session - free resources
     *
     */
    public function close()
    {
        return true;
    }

    /**
     * Read session data
     *
     * @param string $id
     */
    public function read($id)
    {
        $this->check_memcached();
        return (string)$this->memcached->get($id);
    }

    /**
     * Write Session - commit data to resource
     *
     * @param string $id
     * @param mixed $data
     */
    public function write($id, $data)
    {
        $this->check_memcached();

        // Memcache session times out after 24 hours

        $max_life_time = 60 * 60 * 24;

        $res = @$this->memcached->set($id, $data, 0, $max_life_time);

        if ($res === false) { // Simple retry, there is some bug in pecl memcache extension
            return @$this->memcached->set($id, $data, 0, $max_life_time);
        }

        return $res;
    }

    /**
     * Destroy Session - remove data from resource for
     * given session id
     *
     * @param string $id
     */
    public function destroy($id)
    {
        $this->check_memcached();
        return $this->memcached->delete($id);
    }

    /**
     * Garbage Collection - remove old session data older
     * than $maxlifetime (in seconds)
     *
     * @param int $maxlifetime
     */
    public function gc($maxlifetime)
    {
        // Memcached does gc for us
        //
        // We told it via expire in set() when sessions will
        // expire.

        return true;
    }

    /**
     * Checks if memcached has been initialized
     *
     * @return void
     */
    protected function check_memcached()
    {
        if ($this->memcached !== NULL) {
            return;
        }

        $this->memcached = new \Memcache();
        $res = $this->memcached->connect($this->memcached_config['host'], $this->memcached_config['port']);

        if (!$res)
        {
            // One retry
            $res = $this->memcached->connect($this->memcached_config['host'], $this->memcached_config['port']);

            if (!$res) {
                throw new Exception('Cannot connect to memcached (host = ' . $this->memcached_config['host'] . ' port = ' . $this->memcached_config['port'] . ')');
            }
        }
    }

}
