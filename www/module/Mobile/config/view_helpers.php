<?php

/**
 * Common View Helper Configuration File
 *
 * @see http://framework.zend.com/manual/current/en/modules/zend.view.helpers.html
 * @see http://framework.zend.com/manual/current/en/modules/zend.view.helpers.advanced-usage.html
 */
return array(
    'factories'=> array(
        // mobile view helper factories
    ),
    'initializers' => array(
        // mobile view helper initializers
    ),
    'invokables' => array(
        // mobile view helper invokables
        'date_android'       => 'Mobile\Form\View\Helper\FormDateAndroid',
        'tariff_feature'     => 'Mobile\View\Helper\Tariff\Feature',
        'google_tag_manager' => 'Mobile\View\Helper\GoogleTagManager',
    )
);

