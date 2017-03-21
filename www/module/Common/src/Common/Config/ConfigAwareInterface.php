<?php

namespace Common\Config;

use \Zend\Config\Config;

/**
 * Interface ConfigAwareInterface
 *
 * @package Common\Config
 * @author Lars Kneschke <lars.kneschke@check24.de>
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
interface ConfigAwareInterface {

    /**
     * @param Config $config
     *
     * @return mixed
     */
    public function setConfig(Config $config);
}