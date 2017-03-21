<?php

/**
 * Mobile Module Configuration File
 *
 * @see http://framework.zend.com/manual/current/en/tutorials/config.advanced.html
 */
return array(
    'check24' => array(
        'deviceoutput' => array(
            'Mobile' => array(
                'default' => 'mobile',
                'whitelisted' => array('mobile', 'app')
            )
        )
    ),

    // Router Configuration
    'router' => [
        'routes'        => include('routes.php'),
    ],

    // View Helper Configuration
    'view_helpers'      => include('view_helpers.php'),

    // Service Manager Configuration
    'service_manager'   => include('service_manager.php'),

    // Translation Configuration
    'translator'        => include('translator.php'),

    // Controller Configuration
    'controllers'       => include('controllers.php'),

    // View Manager Configuration
    'view_manager'      => include('view_manager.php'),

    // Aspect Manager Configuration
    'aspect_manager'    => include('aspect_manager.php'),
);
