<?php

namespace Common\Config;

use Zend\Config\Config;

/**
 * Trait for config aware classes
 *
 * @package Common\Config
 * @author Lars Kneschke <lars.kneschke@check24.de>
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
trait ConfigAwareTrait {

    /**
     * @var Config $config
     */
    protected $config;

    /**
     * Set the config instance
     *
     * @param Config $config The config instance
     * @return mixed
     */
    public function setConfig(Config $config) {

        $this->config = $config;

        return $this;

    }

    /**
     * Get the config instance
     *
     * @return  Config
     */
    public function getConfig() {

        return $this->config;

    }
}
