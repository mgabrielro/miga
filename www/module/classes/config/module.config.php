<?php

/**
 * Desktop Module Configuration File
 *
 * @see http://framework.zend.com/manual/current/en/tutorials/config.advanced.html
 */
return array(
    // View Manager Configuration
    'view_manager'      => array(
        'template_path_stack' => array(
            __DIR__ . '/../calculation',
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            'tariffnameShortener' => 'Application\View\Helper\TariffnameShortener',
            'tariffnameFormater'  => 'Application\View\Helper\TariffnameFormater'
        )
    )
);