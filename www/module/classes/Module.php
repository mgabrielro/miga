<?php

namespace classes;

class Module {

    /**
     * Get module configuration
     *
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

}