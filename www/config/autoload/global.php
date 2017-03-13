<?php

    if (php_sapi_name() == 'cli') {
        $server_name = 'cli.c24';

    } else {
        $server_name = $_SERVER['SERVER_NAME'];
    }

    /**
     * Global Configuration Override
     *
     * You can use this file for overridding configuration values from modules, etc.
     * You would place values in here that are agnostic to the environment and not
     * sensitive to security.
     *
     * @NOTE: In practice, this file will typically be INCLUDED in your source
     * control, so do not include passwords or other sensitive information in this
     * file.
     */
    return array(
        'miga' => array(
            'environment'         => getenv('APPLICATION_ENV'),
            'logs_dir'            => str_replace("/", DIRECTORY_SEPARATOR, getcwd()."/logs/"),
            'current_application' => 'Application',
            'applications'        => array('Application'),
            'public_path'         => str_replace("/", DIRECTORY_SEPARATOR, getcwd()."/public/"),
            'error_layout'        => getcwd().'/module/Application/view/layout/main.phtml',
        )
    );