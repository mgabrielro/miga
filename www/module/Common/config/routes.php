<?php

/**
 * Common Controller Configuration File
 *
 * @see http://framework.zend.com/manual/current/en/modules/zend.mvc.routing.html
 */
return [
    'ajax_json' => [
        'type' => 'literal',
        'options' => [
            'route'       => '/ajax/json',
            'defaults' => [
                'controller' => 'Common\Controller\Ajax'
            ]
        ],

        'may_terminate' => true,
        'child_routes' => [
            'occupation' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'       => '/occupation/:snippet[/[:limit[/]]]',
                    'constraints' => [
                        'snippet' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'limit'   => '[\d]{1,2}',
                    ],
                    'defaults' => [
                        'action'     => 'getOccupation',
                        'limit' => 1
                    ]
                ]
            ],
            'efeedback' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'       => '/efeedback/:product_id/:provider_id[/]',
                    'defaults' => array(
                        'action'     => 'getFeedback'
                    )
                ]
            ],
            'tariffgrade' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'       => '/tariffgrade/:calculationparameter[/]',
                    'defaults' => array(
                        'action'     => 'getTariffGrade'
                    )
                ]
            ],
            'tariffdetails' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'       => '/tariffdetails/:tariffversion_id/:tariffversion_variation_key/:calculationparameter_id/:mode_id/:tracking_id/:partner_id[/]',
                    'defaults' => array(
                        'action'     => 'getTariffDetails'
                    )
                ]
            ],
            'tarifffeature' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'       => '/tarifffeature/:tariff_id/:calculationparameter_id[/]',
                    'defaults' => array(
                        'action'     => 'getTariffFeature'
                    )
                ]
            ],
            'consultantdata' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/consultantdata/:lead_id[/]',
                    'defaults' => array(
                        'action'     => 'getConsultantData'
                    )
                ]
            ],
            'send_results_per_email' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/send_results_per_email/:mail_to/:calculationparameter_id[/]',
                    'defaults' => array(
                        'action'  => 'getSendResultsPerEmail'
                    )
                ]
            ],
            'handle_favorite' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/handle_favorite/:favorite_action[/[:id[/]]]',
                    'defaults' => array(
                        'action'  => 'getHandleFavorite'
                    )
                ]
            ],
            'count_favorite' => [
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => [
                    'route'    => '/count_favorite/:calculationparameter_id[/]',
                    'defaults' => array(
                        'action'  => 'getCountFavorite'
                    )
                ]
            ]
        ]
    ]
];
