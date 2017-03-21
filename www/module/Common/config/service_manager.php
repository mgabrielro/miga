<?php

return array(
    'factories' => array
    (
        /** Zend Framework */
        'translator'                         => 'Zend\I18n\Translator\TranslatorServiceFactory',

        /** Legacy Classes */
        'classes\register\client\client'     => 'classes\register\client\factory\client_factory',
        '\classes\helper\c24points'          => 'classes\helper\factory\c24points_factory',
        'special_action'                     => 'classes\api\factory\special_action_factory',
        'participating_tariff'               => 'classes\api\factory\participating_tariff_factory',
        'C24Login'                           => 'classes\factory\c24login_factory',
        'classes\wpset'                      => 'classes\factory\wpset_factory',
        'RegisterManager'                    => 'classes\register\factory\registermanager_factory',

        /** Common */
        'SessionContainer'                   => 'Common\Service\Factory\SessionContainerFactory',
        'ZendConfig'                         => 'Common\Config\Factory\ZendConfigFactory',
        'Logger'                             => 'Common\Log\LogFactory',
        'DeviceOutput'                       => 'Common\Service\Factory\DeviceOutputFactory',
        'DeviceType'                         => 'Common\Service\Factory\DeviceTypeFactory',

        /** Check24 */
        'AuthenticationService'               => 'Common\Service\Factory\AuthenticationServiceFactory',
        'AspectManager'                       => 'Common\Aop\Factory\AspectManagerFactory',

        /** Common Session */
        'Common\Session\Memcache'             => 'Common\Session\Factory\MemcacheFactory',
        'Common\Session\Manager'              => 'Common\Session\Factory\SessionManagerFactory',

        /** Common API Client */
        'Common\Api\Client'                   => 'Common\Api\Factory\ClientFactory',

        /** Common API Provider */
        'Common\Provider\City'                => 'Common\Provider\Factory\CityFactory',
        'Common\Provider\Occupation'          => 'Common\Provider\Factory\OccupationFactory',
        'Common\Provider\Street'              => 'Common\Provider\Factory\StreetFactory',
        'Common\Provider\Feedback'            => 'Common\Provider\Factory\FeedbackFactory',
        'Common\Provider\Tariffgrade'         => 'Common\Provider\Factory\TariffGradeFactory',
        'Common\Provider\TariffDetails'       => 'Common\Provider\Factory\TariffDetailsFactory',
        'Common\Provider\TariffFeature'       => 'Common\Provider\Factory\TariffFeatureFactory',
        'Common\Provider\ConsultantData'      => 'Common\Provider\Factory\ConsultantDataFactory',
        'Common\Provider\Holiday'             => 'Common\Provider\Factory\HolidayFactory',
        'Common\Provider\SendResultsPerEmail' => 'Common\Provider\Factory\SendResultsPerEmailFactory',
        'Common\Provider\HandleFavorite'      => 'Common\Provider\Factory\HandleFavoriteFactory',
        'Common\Provider\CountFavorite'      => 'Common\Provider\Factory\CountFavoriteFactory',
        'Common\Provider\PriceCalculationParameter' => 'Common\Provider\Factory\PriceCalculationParameterFactory',
        'ViewTemplatePathStack'               => 'Common\View\Factory\ViewTemplatePathStackFactory',

        /** BPM */
        'Common\BPM\Client'                   => 'Common\BPM\Factory\ClientFactory',
    ),
    'invokables' => array(
        'GuzzleHttp\Client'                   => 'GuzzleHttp\Client'
    ),
    'initializers' => array(
        '\Common\Config\ConfigInitializer',
        '\Common\Log\LogInitializer'
    ),
    'shared' => array(
        'Common\Session\Manager' => false
    )
);