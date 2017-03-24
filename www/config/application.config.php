<?php

use Zend\Mail\Transport\Sendmail;
use Zend\ServiceManager\ServiceManager;

/**
 * Set Application Environment
 */
$environment = getenv('APPLICATION_ENV');

/**
 * Enabled Modules
 */
$modules = [
    'Application',
    'Blog',
    'Album',
    'Product',
];

/*
 * Either load the ErrorHandler module (which converts catchable errors into Exceptions)
 * or load the Zf2Whoops module (when in development mode)
 */
if ($environment === 'development') {
    $modules[] = 'Zf2Whoops';
    $modules[] = 'ZFTool';
}

/**
 * Zend Module Configuration
 */
$config = array(

    'modules'                 => $modules,

    'module_listener_options' => array(

        'config_glob_paths'        => array(
            sprintf('config/autoload/{,*.}{global,%s,local}.php', $environment)
        ),

        'config_cache_enabled'     => false, //($environment !== 'development'),
        'config_cache_key'         => 'app_config',
        'module_map_cache_enabled' => false, //($environment !== 'development'),
        'module_map_cache_key'     => 'module_map',
        //'cache_dir'                => getcwd() . '/data/cache/config/',
        'check_dependencies'       => false, //($environment == 'development'),

        'module_paths'             => array(
            './module',
            './vendor'
        )

    ),

    'service_manager'           => array(
        'factories' => array(
            'DefaultMailer' => function (ServiceManager $serviceManager) {
                return new Sendmail();
            }
        )
    )

);

return $config;
