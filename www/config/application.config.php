<?php

$config = array(

    'modules' => array(
        'Application',
        'Album',
        'Product',
    ),

    'module_listener_options' => array(

        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),

        'module_paths' => array(
            './module',
            './vendor',
        ),

    )

);

return $config;
