<?php

/**
 * Common View Helper Configuration File
 *
 * @see http://framework.zend.com/manual/current/en/modules/zend.view.helpers.html
 * @see http://framework.zend.com/manual/current/en/modules/zend.view.helpers.advanced-usage.html
 */
return array(
    'factories'=> array(
        'authentication' => 'Common\View\Helper\Factory\AuthenticationHelperFactory',
    ),
    'initializers' => array(
        'Common\View\Helper\Initializer\ZendConfigInitializer'
    ),
    'invokables' => array(
        'stars' => 'Common\View\Helper\StarsHelper',
        'truncate'=> 'Common\View\Helper\TruncateHelper',
        'greeting' => 'Common\View\Helper\GreetingHelper'
    )
);