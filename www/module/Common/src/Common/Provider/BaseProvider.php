<?php

namespace Common\Provider;

/**
 * Class BaseProvider
 *
 * @package Common\Service\Module
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
abstract class BaseProvider
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    private $config = null;

    /**
     * Get the value of config
     *
     * @return null|\Zend\Config\Config
     */
    public function getConfig()
    {
        return $this->config;

    }

    /**
     * Set the value of config
     *
     * @param \Zend\Config\Config $config
     * @return BaseProvider
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function __construct(\GuzzleHttp\Client $client, array $config = null) {
        $this->client = $client;

        if (! is_null($config)) {
            $this->config = new \Zend\Config\Config($config);
        }
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getClient() {
        return $this->client;
    }
}