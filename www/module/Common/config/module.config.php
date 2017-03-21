<?php

/**
 * Common Module Configuration File
 *
 * @see http://framework.zend.com/manual/current/en/tutorials/config.advanced.html
 */
return array(

    // Router Configuration
    'router' => [
        'routes'        => require 'routes.php',
    ],

    // View Helper Configuration
    'view_helpers'      => require 'view_helpers.php',

    // Service Manager Configuration
    'service_manager'   => require 'service_manager.php',

    // Translation Configuration
    'translator'        => require 'translator.php',

    // Controller Configuration
    'controllers'       => require 'controllers.php',

    // View Manager Configuration
    'view_manager'      => require 'view_manager.php',

    // Aspect Manager Configuration
    'aspect_manager'    => require 'aspect_manager.php',

);