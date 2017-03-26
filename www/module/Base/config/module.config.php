<?php

namespace Base;

return array(

    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=core;host=localhost',
        'driver_options' => array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        )
    ),

    'service_manager' => array(

        'invokables' => array(
            'Base\Service\PostServiceInterface' => 'Base\Service\PostService'
        ),

        'factories' => array(
            'Zend\Db\Adapter\Adapter'  => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Base\Mapper\PostMapper'   => 'Base\Factory\ZendDbSqlMapperFactory',
            'Base\Service\PostService' => 'Base\Factory\PostServiceFactory',
        )

    ),

    'view_manager' => array(

        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        'template_map' => array(
            'layout/layout'        => __DIR__ . '/../view/layout/layout.phtml',
            'base/index/index'     => __DIR__ . '/../view/base/index/index.phtml',
            'error/404'            => __DIR__ . '/../view/error/404.phtml',
            'error/index'          => __DIR__ . '/../view/error/index.phtml',
            'layout/search'        => __DIR__ . '/../view/base/partials/search.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),

    ),

    'controllers' => array(

        'factories' => array(
            'Base\Controller\Index'  => 'Base\Factory\IndexControllerFactory',
            'Base\Controller\List'   => 'Base\Factory\ListControllerFactory',
            'Base\Controller\Write'  => 'Base\Factory\WriteControllerFactory',
            'Base\Controller\Delete' => 'Base\Factory\DeleteControllerFactory',
            'Base\Controller\Ajax'   => 'Base\Factory\AjaxControllerFactory',
        )

    ),

    'router' => array(

        'routes' => array(

            'home' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Base\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),

            'base' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/base',
                    'defaults' => array(
                        'controller' => 'Base\Controller\List',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'   => array(

                    'detail' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/:id',
                            'defaults' => array(
                                'action' => 'detail'
                            ),
                            'constraints' => array(
                                'id' => '[1-9]\d*'
                            )
                        )
                    ),

                    'add' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route'    => '/add',
                            'defaults' => array(
                                'controller' => 'Base\Controller\Write',
                                'action' => 'add'
                            )
                        )
                    ),

                    'edit' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/edit/:id',
                            'defaults' => array(
                                'controller' => 'Base\Controller\Write',
                                'action' => 'edit'
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            )
                        )
                    ),

                    'delete' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/delete/:id',
                            'defaults' => array(
                                'controller' => 'Base\Controller\Delete',
                                'action' => 'delete'
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            )
                        )
                    ),

                )
            ),

            'ajax' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/ajax',
                    'defaults' => array(
                        'controller' => 'Base\Controller\Ajax',
                        'action'     => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes'  => array(

                    'search' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/search',
                            'defaults' => array(
                                'controller' => 'Base\Controller\Ajax',
                                'action'     => 'search'
                            ),
                        ),
                    ),
                ),

            ),
        )
    )
);