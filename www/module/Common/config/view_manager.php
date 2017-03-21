<?php

/**
 * Common View Manager Configuration File
 *
 * @see http://framework.zend.com/manual/current/en/modules/zend.mvc.services.html#default-configuration-options
 */
return array(
    'display_not_found_reason' => true,
    'display_exceptions'       => true,
    'doctype'                  => 'HTML5',
    'template_path_stack' => array(
        __DIR__ . '/../view',
    ),
    'strategies' => array(
        'ViewJsonStrategy'
    )
);