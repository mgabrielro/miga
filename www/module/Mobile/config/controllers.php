<?php

/**
 * Common Controller Configuration File
 *
 * @see http://framework.zend.com/manual/current/en/tutorials/config.advanced.html
 */
return array(
    'invokables' => array(
        'Mobile\Controller\Index'        => Mobile\Controller\IndexController::class,
        'Mobile\Controller\Register'     => Mobile\Controller\RegisterController::class,
        'Mobile\Controller\Login'        => Mobile\Controller\LoginController::class,
        'Mobile\Controller\Input1'       => Mobile\Controller\Input1Controller::class,
        'Mobile\Controller\Result'       => Mobile\Controller\ResultController::class,
        'Mobile\Controller\Compare'      => Mobile\Controller\CompareController::class,
        'Mobile\Controller\TariffDetail' => Mobile\Controller\TariffDetailController::class,
        'Mobile\Controller\Favorite'     => Mobile\Controller\FavoriteController::class,
    )
);
