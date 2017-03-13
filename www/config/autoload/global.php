<?php

    if (php_sapi_name() == 'cli') {
        $server_name = 'cli.c24';

    } else {
        $server_name = $_SERVER['SERVER_NAME'];
    }

    /**
     * Global Configuration Override
     *
     * You can use this file for overridding configuration values from modules, etc.
     * You would place values in here that are agnostic to the environment and not
     * sensitive to security.
     *
     * @NOTE: In practice, this file will typically be INCLUDED in your source
     * control, so do not include passwords or other sensitive information in this
     * file.
     */
    return array(
        'miga' => array(
            'environment'         => getenv('APPLICATION_ENV'),
            'logs_dir'            => str_replace("/", DIRECTORY_SEPARATOR, getcwd()."/logs/"),
            'current_application' => 'Application',
            'applications'        => array('Application'),
            'public_path'         => str_replace("/", DIRECTORY_SEPARATOR, getcwd()."/public/"),
            'error_layout'        => getcwd().'/module/Application/view/layout/main.phtml',
            /*'piwik' => array(
                'enabled' => true,
                'siteid'  => 1,
                'url'     => '//tracking.daniele.c24/',
                'plugins' => [
                    'trackPageView',
                    'enableLinkTracking',
                    'setDoNotTrack' => true
                ],
            ),
            'partner_id' => 24,
            'efeedback' => array(
                'api' => array(
                    'endpoint' => 'https://efeedback.de/app/api/v1/'
                ),
                'min_ratings_for_significance' => 10
            ),
            'calculation' => array(
                'api' => array(
                    //'host' => '',
                    'base_uri' => '/app/api/',
                    'user' => 'energy',
                    'pass' => 'k6hZGT6osmne4R',
                    'log_path'  => getcwd() . '/logs/api.log',
                    'view_path' => 'module/classes/calculation/client/view/',
                    'register_link' => '/pkv/angebotsseite1/einsprung/'
                )
            ),
            'register' => array(
                'api' => array(
                    'base_uri' => '/app/api/',
                    'user' => 'energy',
                    'pass' => 'k6hZGT6osmne4R'
                )
            ),*/
            /*'memcached' => array(
                'port' => '11211'
            ),
            'redis' => array(
                'prefix' => md5(__DIR__),
                'port' => 6379
            ),
            'wurfl' => array(
                'home'     => getcwd().'/vendor/check24/wurflapi',
                'resource' => '/var/lib/wurfl/current',
                'config_file'  => 'http://www.scientiamobile.com/wurfl/uukjw/wurfl.zip'
            ),
            'c24login' => array(
                'service' => array(
                    'id' => 89,
                    'secret' => 'ukkOWnX5duLb.Dv0'
                )
            ),
            'urls' => array(
                'pointplan_images' => '/assets/images/form/c24points/'
            ),
            'xhprof' => array(
                'enabled' => false,
                'path' => null
            ),
            'cache' => array(
                'ttl' => array(
                    'classes\api\participating_tariff::get_api_result' => 60 * 10,
                    'classes\api\special_action::get_api_result'       => 60 * 10,
                    'C24Efeedback\Service\EfeedbackApiClient::get_stats'  => 60 * 60 * 5,
                    'C24Efeedback\Service\EfeedbackApiClient::get_customer_reviews'  => 60 * 60 * 5,
                    'C24Efeedback\Service\EfeedbackApiClient::get_test_reports'  => 60 * 60 * 5
                )
            ),
            'project' => array(
                'home' => realpath(getcwd() . '/../')
            ),
            'holdingwireframe' => array (
                'development' => 'https://m.check24.de/wf/ver/sec/generic/',
                'testing' => 'https://m.check24-int.de/wf/ver/sec/generic/',
                'staging'=> 'https://m.check24-int.de/wf/ver/sec/generic/',
                'production' => 'https://m.check24.de/wf/ver/sec/generic/'
            ),
            'enable_basic_authentication' => false,
            'enable_debug_log' => false,
            'cache_path' => getcwd() . '/data/cache/',
            # needed for mobile
            'install_timestamp' => 1,

            // Toggle Monolog's BrowserConsoleHandler which writes all logs to browser console.
            // Enabling this will work only on "development" environment
            'log_in_browser_console' => false,

            'bpm' => array(
                'domains'    => ['https://bpm1.check24.de', 'https://bpm2.check24.de'], // BPM API domains
                'base_uri'   => '/api/prefilling/',                                     // Base URI for actions (get, set)
                'service_id' => 36,                                                     // SSO Service ID for our product (in our case for Personenversicherung)
                'secret'     => '34745cc6fa8b6e047ac47f36b5a21384',                     // Very secret key
                'product_key' => 'pkv',                                                 // Product ID for BPM
                'cookie_domain' => array(                                               // Cookie domain
                    'development'   => '.' . $server_name,
                    'testing'       => '.' . $server_name,
                    'staging'       => '.check24.test',
                    'production'    => '.check24.de',
                ),
            ),*/
        )
    );