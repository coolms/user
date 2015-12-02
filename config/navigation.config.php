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
    'cmsadminmodules' => [
        'user' => [
            'label' => 'Users',
            'title' => 'Users',
            'text_domain' => __NAMESPACE__,
            'may_terminate' => true,
            'route' => 'cms-admin/user',
            'twbs' => [
                'labelWrapper' => [
                    'type' => 'htmlContainer',
                    'tagName' => 'span',
                ],
                'icon' => [
                    'type' => 'fa',
                    'content' => 'group',
                    'placement' => 'prepend',
                    'tagName' => 'i',
                ],
            ],
            'pages' => [
                'list' => [
                    'label' => 'List',
                    'title' => 'User list',
                    'text_domain' => __NAMESPACE__,
                    'may_terminate' => true,
                    'route' => 'cms-admin/user',
                    'params' => [
                        'controller' => 'user',
                        'action' => 'list',
                    ],
                    'ul_class' => 'btn-toolbar text-nowrap',
                    'class' => 'btn-group',
                    'attribs' => [
                        'class' => 'btn btn-default',
                    ],
                    'twbs' => [
                        'labelWrapper' => [
                            'tagName' => 'span',
                            'class' => 'hidden-xs hidden-sm hidden-md',
                        ],
                        'icon' => [
                            'type' => 'fa',
                            'content' => 'list',
                            'placement' => 'prepend',
                            'tagName' => 'i',
                        ],
                    ],
                    'pages' => [
                        'update' => [
                            'label' => 'Update',
                            'title' => 'User update',
                            'text_domain' => __NAMESPACE__,
                            'visible' => false,
                            'route' => 'cms-admin/user',
                            'params' => [
                                'controller' => 'user',
                                'action' => 'update',
                            ],
                            'link_placeholders' => [
                                'id' => ':id',
                            ],
                            'class' => 'btn-group',
                            'attribs' => [
                                'class' => 'btn btn-primary',
                            ],
                            'twbs' => [
                                'labelWrapper' => [
                                    'tagName' => 'span',
                                    'class' => 'sr-only',
                                ],
                                'icon' => [
                                    'type' => 'fa',
                                    'content' => 'edit',
                                    'placement' => 'prepend',
                                    'tagName' => 'i',
                                ],
                            ],
                        ],
                        'remove' => [
                            'label' => 'Remove',
                            'title' => 'User remove',
                            'text_domain' => __NAMESPACE__,
                            'visible' => false,
                            'route' => 'cms-admin/user',
                            'params' => [
                                'controller' => 'user',
                                'action' => 'delete',
                                'id' => ':id',
                            ],
                            'class' => 'btn-group',
                            'attribs' => [
                                'class' => 'btn btn-danger',
                            ],
                            'twbs' => [
                                'labelWrapper' => [
                                    'tagName' => 'span',
                                    'class' => 'sr-only',
                                ],
                                'icon' => [
                                    'type' => 'fa',
                                    'content' => 'remove',
                                    'placement' => 'prepend',
                                    'tagName' => 'i',
                                ],
                            ],
                        ],
                        'actions' => [
                            'label' => 'Actions',
                            'title' => 'Actions',
                            'text_domain' => __NAMESPACE__,
                            'visible' => false,
                            'uri' => '',
                            'ul_class' => 'dropdown-menu',
                            'class' => 'btn-group',
                            'attribs' => [
                                'class' => 'btn btn-default dropdown-toggle',
                                'data-toggle' => 'dropdown',
                                'aria-haspopup' => 'true',
                                'aria-expanded' => 'false',
                            ],
                            'twbs' => [
                                'labelWrapper' => [
                                    'tagName' => 'span',
                                    'class' => 'sr-only',
                                ],
                                'icon' => [
                                    'type' => 'fa',
                                    'content' => 'reorder',
                                    'placement' => 'prepend',
                                    'tagName' => 'i',
                                ],
                                'caret' => [
                                    'tagName' => 'span',
                                    'class' => 'caret',
                                    'placement' => 'append',
                                ],
                            ],
                            'pages' => [],
                        ],
                    ],
                ],
                'create' => [
                    'label' => 'Create',
                    'title' => 'User creation',
                    'text_domain' => __NAMESPACE__,
                    'route' => 'cms-admin/user',
                    'params' => [
                        'controller' => 'user',
                        'action' => 'create',
                    ],
                    'class' => 'btn-group',
                    'attribs' => [
                        'class' => 'btn btn-success',
                    ],
                    'twbs' => [
                        'labelWrapper' => [
                            'tagName' => 'span',
                            'class' => 'hidden-xs hidden-sm hidden-md',
                        ],
                        'icon' => [
                            'type' => 'fa',
                            'content' => 'plus',
                            'placement' => 'prepend',
                            'tagName' => 'i',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'cmsadminidentity' => [
        [
            'label' => 'Edit Profile',
            'text_domain' => __NAMESPACE__,
            'route' => 'cms-admin/edit-profile',
            'params' => ['action' => 'edit-profile'],
            'order' => -1000,
            'twbs' => [
                'icon' => [
                    'type' => 'fa',
                    'content' => 'pencil',
                    'placement' => 'append',
                    'tagName' => 'i',
                    'class' => 'pull-right',
                ],
            ],
        ],
    ],
    'cmsuser' => [
        [
            'label' => 'Edit Profile',
            'text_domain' => __NAMESPACE__,
            'route' => 'cms-user/default',
            'params' => ['action' => 'edit-profile'],
            'resource' => 'route/cms-user/default',
            'order' => 900,
            'twbs' => [
                'icon' => [
                    'type' => 'fa',
                    'content' => 'pencil',
                    'placement' => 'prepend',
                    'tagName' => 'i',
                ],
            ],
        ],
        [
            'label' => 'Change Password',
            'text_domain' => __NAMESPACE__,
            'route' => 'cms-user/default',
            'params' => ['action' => 'change-password'],
            'resource' => 'route/cms-user/default',
            'order' => 910,
            'twbs' => [
                'icon' => [
                    'type' => 'fa',
                    'content' => 'lock',
                    'placement' => 'prepend',
                    'tagName' => 'i',
                ],
            ],
        ],
        [
            'label' => 'Change Email',
            'text_domain' => __NAMESPACE__,
            'route' => 'cms-user/default',
            'params' => ['action' => 'change-email'],
            'resource' => 'route/cms-user/default',
            'order' => 920,
            'twbs' => [
                'icon' => [
                    'type' => 'fa',
                    'content' => 'envelope',
                    'placement' => 'prepend',
                    'tagName' => 'i',
                ],
            ],
        ],
        [
            'label' => 'Change Security Question',
            'text_domain' => __NAMESPACE__,
            'route' => 'cms-user/default',
            'params' => ['action' => 'change-security-question'],
            'resource' => 'route/cms-user/default',
            'order' => 930,
            'twbs' => [
                'labelWrapper' => [
                    'type' => 'htmlContainer',
                    'tagName' => 'span',
                ],
                'icon' => [
                    'type' => 'fa',
                    'content' => 'question',
                    'placement' => 'prepend',
                    'tagName' => 'i',
                ],
            ],
        ],
        [
            'order' => 940,
            'uri' => '',
            'class' => 'divider',
        ],
        [
            'label' => 'Sign Out',
            'text_domain' => 'CmsAuthentication',
            'route' => 'cms-user/logout',
            'resource' => 'route/cms-user/logout',
            'order' => 1000,
            'twbs' => [
                'icon' => [
                    'type' => 'fa',
                    'content' => 'sign-out',
                    'placement' => 'prepend',
                    'tagName' => 'i',
                ],
            ],
        ],
    ],
    'cmsuseridentity' => [
        [
            'label' => 'Sign Up',
            'title' => 'Sign Up',
            'text_domain' => __NAMESPACE__,
            'route' => 'cms-user/register',
            'resource' => 'route/cms-user/register',
            'order' => 0,
        ],
        [
            'label' => 'User',
            'label_helper' => 'cmsUserDisplayName',
            'text_domain' => __NAMESPACE__,
            'route' => 'cms-user',
            'resource' => 'route/cms-user',
            'order' => 50,
            'class' => 'dropdown',
            'ul_class' => 'dropdown-menu',
            'attribs' => [
                'data-toggle' => 'dropdown',
                'class' => 'dropdown-toggle',
            ],
            'twbs' => [
                'icon' => [
                    'type' => 'fa',
                    'content' => 'user',
                    'placement' => 'prepend',
                    'tagName' => 'i',
                ],
                'caret' => [
                    'type' => 'htmlContainer',
                    'placement' => 'append',
                    'tag' => 'i',
                    'class' => 'caret',
                ],
            ],
            'pages' => [
                [
                    'label' => 'Edit Profile',
                    'text_domain' => __NAMESPACE__,
                    'route' => 'cms-user/default',
                    'params' => ['action' => 'edit-profile'],
                    'resource' => 'route/cms-user/default',
                    'order' => 0,
                    'twbs' => [
                        'labelWrapper'  => [
                            'type' => 'htmlContainer',
                            'tagName' => 'span',
                        ],
                        'icon' => [
                            'type' => 'fa',
                            'content' => 'pencil',
                            'placement' => 'prepend',
                            'tagName' => 'i',
                            'class' => 'pull-right',
                        ],
                    ],
                ],
                [
                    'label' => 'Change Password',
                    'text_domain' => __NAMESPACE__,
                    'route' => 'cms-user/default',
                    'params' => ['action' => 'change-password'],
                    'resource' => 'route/cms-user/default',
                    'order' => 50,
                    'twbs' => [
                        'icon' => [
                            'type' => 'fa',
                            'content' => 'lock',
                            'placement' => 'prepend',
                            'tagName' => 'i',
                            'class' => 'pull-right',
                        ],
                    ],
                ],
                [
                    'label' => 'Change Email',
                    'text_domain' => __NAMESPACE__,
                    'route' => 'cms-user/default',
                    'params' => ['action' => 'change-email'],
                    'resource' => 'route/cms-user/default',
                    'order' => 100,
                    'twbs' => [
                        'icon' => [
                            'type' => 'fa',
                            'content' => 'envelope',
                            'placement' => 'prepend',
                            'tagName' => 'i',
                            'class' => 'pull-right',
                        ],
                    ],
                ],
                [
                    'label' => 'Change Security Question',
                    'text_domain' => __NAMESPACE__,
                    'route' => 'cms-user/default',
                    'params' => ['action' => 'change-security-question'],
                    'resource' => 'route/cms-user/default',
                    'order' => 150,
                    'twbs' => [
                        'labelWrapper' => [
                            'type' => 'htmlContainer',
                            'tagName' => 'span',
                        ],
                        'icon' => [
                            'type' => 'fa',
                            'content' => 'question',
                            'placement' => 'prepend',
                            'tagName' => 'i',
                            'class' => 'pull-right',
                        ],
                    ],
                ],
                [
                    'order' => 950,
                    'uri' => '',
                    'class' => 'divider',
                ],
                [
                    'label' => 'Sign Out',
                    'text_domain' => 'CmsAuthentication',
                    'route' => 'cms-user/logout',
                    'resource' => 'route/cms-user/logout',
                    'order' => 1000,
                    'attribs' => [
                        'class' => 'text-right',
                    ],
                    'twbs' => [
                        'icon' => [
                            'type' => 'fa',
                            'content' => 'sign-out',
                            'placement' => 'prepend',
                            'tagName' => 'i',
                        ],
                    ],
                ],
            ],
        ],
        [
            'label' => 'Sign In',
            'title' => 'Sign In',
            'text_domain' => 'CmsAuthentication',
            'route' => 'cms-user/login',
            'resource' => 'route/cms-user/login',
            'order' => 100,
            'twbs' => [
                'icon' => [
                    'type' => 'fa',
                    'content' => 'sign-in',
                    'placement' => 'prepend',
                    'tagName' => 'i'
                ],
            ],
        ],
    ],
];
