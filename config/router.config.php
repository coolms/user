<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser;

return [
    'routes' => [
        'cms-admin' => [
            'child_routes' => [
                'user' => [
                    'type' => 'Literal',
                    'options' => [
                        'route' => '/user',
                        'defaults' => [
                            '__NAMESPACE__' => 'CmsUser\Controller',
                            'controller' => 'admin',
                            'action' => 'index',
                        ],
                    ],
                    'may_terminate' => true,
                    'child_routes' => [
                        'default' => [
                            'type' => 'Segment',
                            'options' => [
                                'route' => '[/:controller[/:action[/:id]]]',
                                'constraints' => [
                                    'controller' => '[a-zA-Z\-]*',
                                    'action' => '[a-zA-Z\-]*',
                                    'id' => '[0-9]*',
                                ],
                                'defaults' => [
                                    'controller' => 'user',
                                    'action' => 'index',
                                ],
                            ],
                        ],
                        
                    ],
                ],
            ],
        ],
        'cms-user' => [
            'type' => 'Literal',
            'options' => [
                'route' => '/user',
                'defaults' => [
                    '__NAMESPACE__' => 'CmsUser\Controller',
                    'controller' => 'Index',
                    'action' => 'index',
                ],
            ],
            'priority' => 9001,
            'may_terminate' => true,
            'child_routes' => [
                'default' => [
                    'type' => 'Segment',
                    'options' => [
                        'route' => '[/:action[/:token]]',
                        'constraints' => [
                            'action' => '[a-zA-Z\-]*',
                            'token' => '([a-zA-Z0-9]{32})*',
                        ],
                        'defaults' => [
                            'action' => 'index',
                        ],
                    ],
                ],
                'login' => [
                    'type' => 'Literal',
                    'options' => [
                        'route' => '/login',
                        'defaults' => [
                            '__NAMESPACE__' => 'CmsAuthentication\Controller',
                            'controller' => 'Authentication',
                            'action' => 'login',
                            'module_options' => [
                                'CmsAuthentication\Options\ModuleOptions' => [
                                    'registration_route' => 'cms-user/register',
                                    'reset_credential_route' => 'cms-user/reset-password',
                                    'login_redirect_route' => 'cms-user',
                                ],
                            ],
                        ],
                    ],
                ],
                'logout' => [
                    'type' => 'Literal',
                    'options' => [
                        'route' => '/logout',
                        'defaults' => [
                            '__NAMESPACE__' => 'CmsAuthentication\Controller',
                            'controller' => 'Authentication',
                            'action' => 'logout',
                            'module_options' => [
                                'CmsAuthentication\Options\ModuleOptions' => [
                                    'logout_redirect_route' => 'cms-user',
                                ],
                            ],
                        ],
                    ],
                ],
                'reset-password' => [
                    'type' => 'Segment',
                    'options' => [
                        'route' => '/reset-password[/:token]',
                        'constraints' => [
                            'token' => '([a-zA-Z0-9]{32})*',
                        ],
                        'defaults' => [
                            'controller' => 'Authentication',
                            'action' => 'reset-password',
                        ],
                    ],
                ],
                'register' => [
                    'type' => 'Segment',
                    'options' => [
                        'route' => '/register',
                        'defaults' => [
                            'controller' => 'Registration',
                            'action' => 'index',
                        ],
                    ],
                    'may_terminate' => true,
                    'child_routes' => [
                        'confirm' => [
                            'type' => 'Segment',
                            'options' => [
                                'route' => '/:token',
                                'constraints' => [
                                    'token' => '[a-zA-Z0-9]{32}',
                                ],
                                'defaults' => [
                                    'controller' => 'Index',
                                    'action' => 'confirm-email',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
