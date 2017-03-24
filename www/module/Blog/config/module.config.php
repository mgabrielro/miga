<?php

return array(

    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=gmblog;host=localhost',
        'driver_options' => array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        )
    ),

    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'  => 'Zend\Db\Adapter\AdapterServiceFactory',
            'Blog\Mapper\PostMapper'   => 'Blog\Factory\ZendDbSqlMapperFactory',
            'Blog\Service\PostService' => 'Blog\Factory\PostServiceFactory',
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
            'blog/index/index'     => __DIR__ . '/../view/blog/index/index.phtml',
            'error/404'            => __DIR__ . '/../view/error/404.phtml',
            'error/index'          => __DIR__ . '/../view/error/index.phtml',
            'layout/search'        => __DIR__ . '/../view/blog/partials/search.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),

    ),

    'controllers' => array(

        'invokables' => array(
            'Blog\Controller\Index' => 'Blog\Controller\IndexController',
        ),

        'factories' => array(
            'Blog\Controller\List'   => 'Blog\Factory\ListControllerFactory',
            'Blog\Controller\Write'  => 'Blog\Factory\WriteControllerFactory',
            'Blog\Controller\Delete' => 'Blog\Factory\DeleteControllerFactory',
            'Blog\Controller\Ajax'   => 'Blog\factory\AjaxControllerFactory',
        )

    ),

    // This lines opens the configuration for the RouteManager
    'router' => array(
        // Open configuration for all possible routes
        'routes' => array(

            'home' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),

            'blog' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\List',
                        'action'     => 'index',
                    )
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
                                'controller' => 'Blog\Controller\Write',
                                'action' => 'add'
                            )
                        )
                    ),

                    'edit' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '/edit/:id',
                            'defaults' => array(
                                'controller' => 'Blog\Controller\Write',
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
                                'controller' => 'Blog\Controller\Delete',
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
                        'controller' => 'Blog\Controller\Ajax',
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
                                'controller' => 'Blog\Controller\Ajax',
                                'action'     => 'search'
                            ),
                            /*'constraints' => array(
                                'term' => '[a-zA-Z0-9]+'
                            )*/
                        ),
                    ),
                )

            ),
        )
    )
);