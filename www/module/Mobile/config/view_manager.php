<?php

/**
 * Common View Manager Configuration File
 *
 * @see http://framework.zend.com/manual/current/en/modules/zend.mvc.services.html#default-configuration-options
 */
return array(
    #'display_not_found_reason' => true,
    #'display_exceptions'       => true,
    'doctype'                  => 'HTML5',
    'not_found_template'       => 'error/404',
    'exception_template'       => 'error/index',
    'template_map' => array(
        'layout/main'               => getcwd() . '/module/Application/view/layout/main.phtml',
        'layout/register'           => getcwd() . '/module/Application/view/layout/main_register.phtml',
        'layout/result'             => getcwd() . '/module/Application/view/layout/main_result.phtml',
        'layout/thankyou'           => getcwd() . '/module/Application/view/layout/main_thankyou.phtml',
        'application/index/index'   => getcwd() . '/../view/application/index/index.phtml',
        'error/404'                 => getcwd() . '/module/Mobile/view/error/404.phtml',
        'error/index'               => getcwd() . '/module/Mobile/view/error/index.phtml',
    ),
    'template_path_stack' => array(
        __DIR__ . '/../view',
    ),
    'strategies' => array(
        'ViewJsonStrategy',
    )
);