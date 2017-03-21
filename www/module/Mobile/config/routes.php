<?php

return [
    'mobile' => [
        'type' => 'hostname',
        'may_terminate' => true,
        'child_routes' => [
            'home' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => 'Mobile\Controller\Index',
                        'action'     => 'index',
                    ],
                ]
            ],
            'oauth_close' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/oauth/close[/]',
                    'defaults' => [
                        'controller' => 'Mobile\Controller\Input1',
                        'action'     => 'oauthClose',
                    ],
                ],
            ],
            'pkv' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/pkv/',
                    'defaults' => [
                        'controller' => 'Mobile\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'test' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => 'test/:hash[/]',
                            'defaults' => [
                                'controller' => 'Mobile\Controller\Input1',
                                'action' => 'test',
                            ],
                        ],
                    ],
                    'input1' => [
                        'type' => 'literal',
                        'options' => [
                            'route'    => 'benutzereingaben/',
                            'defaults' => [
                                'controller' => 'Mobile\Controller\Input1',
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'result' => [
                        'type' => 'literal',
                        'options' => [
                            'route'    => 'vergleichsergebnis/',
                            'defaults' => [
                                'controller' => 'Mobile\Controller\Result',
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'tariffdetail' => [
                        'type' => 'segment',
                        'options' => [
                            'route'    => 'tariffdetail/',
                            'defaults' => [
                                'controller' => 'Mobile\Controller\TariffDetail',
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'compare' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => 'tarifvergleich/:calculationparameter_id/:tarif1/:tarif2[/]',
                            'defaults' => [
                                'controller' => 'Mobile\Controller\Compare',
                                'action' => 'index',
                            ]
                        ],
                    ],
                    'favorite' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => 'merkzettel/',
                            'defaults' => [
                                'controller' => 'Mobile\Controller\Favorite',
                                'action'     => 'index',
                            ]
                        ],
                    ],
                    'register' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'       => 'antragstrecke/:product_id/:registercontainer_id/:step/[:subscriptiontype/][:login_type/]',
                            'constraints' => array(
                                'product_id'              => '2[0-9]',
                                'calculationparameter_id' => '[0-9a-f]{32}',
                                'step'                    => '([a-z\-\_\d]+)',
                                'subscriptiontype'        => '(offer|expert)?',
                                'login_type'              => '(user|register|recover)?'
                            ),
                            'defaults' => array(
                                'controller' => 'Mobile\Controller\Register',
                                'action'     => 'index',
                                'force-ssl'  => 'ssl',
                            ),
                        ),
                    ),
                    'register_create' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'       => 'antragstrecke/einsprung/[:product_id]/[:calculationparameter_id]/[:tariffversion_id]/[:tariffversion_variation_key]/[:subscriptiontype]/',
                            'constraints' => array(
                                'product_id'                  => '2[0-9]',
                                'calculationparameter_id'     => '[0-9a-f]{32}',
                                'tariffversion_id'            => '[0-9]+',
                                'tariffversion_variation_key' => '((base|b\-[\d]+)((\-b\-[\d]+)+)?)',
                                'subscriptiontype'            => '(offer|expert)?'
                            ),
                            'defaults' => array(
                                'controller' => 'Mobile\Controller\Register',
                                'action'     => 'create',
                                'force-ssl'  => 'ssl',
                            ),
                        ),
                    ),
                    'register_create_online' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'       => 'antragstrecke/einsprung/online/[:product_id]/[:calculationparameter_id]/[:tariffversion_id]/[:tariffversion_variation_key]/',
                            'constraints' => array(
                                'product_id'                  => '2[0-9]',
                                'calculationparameter_id'     => '[0-9a-f]{32}',
                                'tariffversion_id'            => '[0-9]+',
                                'tariffversion_variation_key' => '((base|b\-[\d]+)((\-b\-[\d]+)+)?)'
                            ),
                            'defaults' => array(
                                'controller' => 'Mobile\Controller\Register',
                                'action'     => 'createOnline',
                                'force-ssl'  => 'ssl',
                            ),
                        ),
                    ),
                    'register_create_offline' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'       => 'antragstrecke/einsprung/offline/[:product_id]/[:calculationparameter_id]/[:tariffversion_id]/[:tariffversion_variation_key]/',
                            'constraints' => array(
                                'product_id'                  => '2[0-9]',
                                'calculationparameter_id'     => '[0-9a-f]{32}',
                                'tariffversion_id'            => '[0-9]+',
                                'tariffversion_variation_key' => '((base|b\-[\d]+)((\-b\-[\d]+)+)?)',
                            ),
                            'defaults' => array(
                                'controller' => 'Mobile\Controller\Register',
                                'action'     => 'createOffline',
                                'force-ssl'  => 'ssl',
                            )
                        )
                    )
                ]
            ]
        ]
    ]
];
