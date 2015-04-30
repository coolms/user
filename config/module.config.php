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
    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../public',
            ],
        ],
    ],
    'cmsauthentication' => [
        'login_route' => 'cms-user/login',
        'login_redirect_route' => 'cms-user',
        'logout_redirect_route' => 'cms-user',
        'authentication_adapters' => [
            100 => 'CmsUser\Authentication\Adapter\DefaultAdapter',
        ],
    ],
    'cmsauthorization' => [
        'unauthorized_strategy' => 'CmsAuthorization\View\Strategy\RedirectStrategy',
    ],
    'cmspermissions' => [
        'acl' => [
            'guards' => [
                'CmsAcl\Guard\Route' => [
                    ['route' => 'cms-admin/user', 'roles' => ['admin']],
                    ['route' => 'cms-admin/user/default', 'roles' => ['admin']],

                    ['route' => 'cms-user', 'roles' => ['user']],
                    ['route' => 'cms-user/default', 'roles' => ['user']],
                    ['route' => 'cms-user/logout', 'roles' => ['user']],
                    ['route' => 'cms-user/login', 'roles' => ['guest']],
                    ['route' => 'cms-user/reset-password', 'roles' => ['guest']],
                    ['route' => 'cms-user/register', 'roles' => ['guest']],
                    ['route' => 'cms-user/register/confirm', 'roles' => []],
                ],
            ],
        ],
    ],
    'cmslayout' => [
        'layouts' => [
            'cms-user' => 'layout/cmsuser-layout',
        ],
    ],
    'controllers' => [
        'factories' => [
            'CmsUser\Controller\Authentication'
                => 'CmsUser\Factory\Controller\AuthenticationControllerFactory',
            'CmsUser\Controller\Index'
                => 'CmsUser\Factory\Controller\IndexControllerFactory',
            'CmsUser\Controller\Registration'
                => 'CmsUser\Factory\Controller\RegistrationControllerFactory',
        ],
        'invokables' => [
            'CmsUser\Controller\Admin' => 'CmsUser\Factory\Controller\AdminController',
        ],
    ],
    'doctrine' => [
        'driver' => [
            'cmsuser_metadata_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity',
                 ],
            ],
            'orm_default' => [
                'drivers' => [
                    'CmsUser\Entity' => 'cmsuser_metadata_driver',
                ],
            ],
        ],
        'entity_resolver' => [
            'orm_default' => [
                'resolvers' => [
                    'CmsUser\Mapping\UserInterface' => 'CmsUser\Entity\User',
                ],
            ],
        ],
    ],
    'mappers' => [
        'delegators' => [
            'CmsUser\Entity\User' => ['CmsUser\Factory\Persistence\UserMapperDelegatorFactory'],
        ],
    ],
    'domain_services' => [
        'aliases' => [
            'CmsUser\Entity\User' => 'CmsUser\Service\UserServiceInterface',
        ],
        'factories' => [
            'CmsUser\Service\UserServiceInterface' => 'CmsUser\Factory\UserServiceFactory',
        ],
    ],
    'form_elements' => [
        'aliases' => [
            'CmsUserBirthday' => 'CmsUser\Form\Element\Birthday',
            'CmsUserBirthdayVerify' => 'CmsUser\Form\Element\BirthdayVerify',
            'CmsUserEmail' => 'CmsUser\Form\Element\Email',
            'CmsUserMobilePhoneNumber' => 'CmsUser\Form\Element\MobilePhoneNumber',
            'CmsUserUsername' => 'CmsUser\Form\Element\Username',
        ],
        'delegators' => [
            'CmsAuthentication\Form\Element\Identity' => [
                'CmsUser\Factory\Form\Element\IdentityElementDelegatorFactory',
            ],
        ],
        'factories' => [
            'CmsUser\Form\Element\Birthday'
                => 'CmsUser\Factory\Form\Element\BirthdayElementFactory',
            'CmsUser\Form\Element\BirthdayVerify'
                => 'CmsUser\Factory\Form\Element\BirthdayVerifyElementFactory',
            'CmsUser\Form\ChangeEmail'
                => 'CmsUser\Factory\Form\ChangeEmailFormFactory',
            'CmsUser\Form\ChangePassword'
                => 'CmsUser\Factory\Form\ChangePasswordFormFactory',
            'CmsUser\Form\ChangeSecurityQuestion'
                => 'CmsUser\Factory\Form\ChangeSecurityQuestionFormFactory',
            'CmsUser\Form\EditProfile'
                => 'CmsUser\Factory\Form\EditProfileFormFactory',
            'CmsUser\Form\Register'
                => 'CmsUser\Factory\Form\RegisterFormFactory',
            'CmsUser\Form\ResetPassword'
                => 'CmsUser\Factory\Form\ResetPasswordFormFactory',
        ],
        'invokables' => [
            'CmsUser\Form\Element\Email' => 'CmsUser\Form\Element\Email',
            'CmsUser\Form\Element\MobilePhoneNumber'
                => 'CmsUser\Form\Element\MobilePhoneNumber',
            'CmsUser\Form\Element\Username' => 'CmsUser\Form\Element\Username',
        ],
    ],
    'listeners' => [
        'CmsUser\Event\BlameableListener' => 'CmsUser\Event\BlameableListener',
        'CmsUser\Event\RegistrationListener' => 'CmsUser\Event\RegistrationListener',
    ],
    'navigation' => [
        'cms-admin' => [
            [
                'label' => 'Users',
                'title' => 'Users',
                'text_domain' => __NAMESPACE__,
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
            ],
        ],
        'cms-admin-identity' => [
            [
                'label' => 'Edit Profile',
                'text_domain' => __NAMESPACE__,
                'route' => 'cms-admin/user/default',
                'params' => ['action' => 'update'],
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
        'cms-user' => [
            [
                'label' => 'Sign Up',
                'title' => 'Sign Up',
                'text_domain' => __NAMESPACE__,
                'route' => 'cms-user/register',
                'resource' => 'route/cms-user/register',
                'order' => 0,
            ],
            [
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
    ],
    'router' => [
        'routes' => [
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
                                        '__NAMESPACE__' => 'CmsUser\Controller',
                                        'controller' => 'user',
                                        'action' => 'index',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'CmsUser\Event\BlameableListener' => 'CmsUser\Event\BlameableListener',
            'CmsUser\Event\RegistrationListener' => 'CmsUser\Event\RegistrationListener',
            'CmsUser\MailService' => 'CmsMailer\Service\MailService',
        ],
        'factories' => [
            'Zend\Authentication\Storage\StorageInterface'
                => 'CmsUser\Factory\Authentication\StorageFactory',
            'Zend\Crypt\Password\PasswordInterface'
                => 'CmsUser\Factory\CryptoPasswordServiceFactory',
            'CmsUser\Authentication\Adapter\DefaultAdapter'
                => 'CmsUser\Factory\Authentication\AdapterFactory',
            'CmsUser\Navigation'
                => 'CmsUser\Factory\NavigationFactory',
            'CmsUser\Options\ModuleOptions'
                => 'CmsUser\Factory\ModuleOptionsFactory',
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
                'text_domain' => __NAMESPACE__,
            ],
            [
                'type' => 'phpArray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php',
            ],
        ],
    ],
    'validators' => [
        'delegators' => [
            'CmsAuthenticationIdentity' => ['CmsUser\Factory\Validator\IdentityValidatorDelegatorFactory'],
        ],
        'factories' => [
            'CmsUserAnswerVerify' => 'CmsUser\Factory\Validator\AnswerVerifyValidatorFactory',
            'CmsUserEmailAddress' => 'CmsUser\Factory\Validator\EmailAddressValidatorFactory',
            'CmsUserBirthday' => 'CmsUser\Factory\Validator\BirthdayValidatorFactory',
            'CmsUserBirthdayVerify' => 'CmsUser\Factory\Validator\BirthdayVerifyValidatorFactory',
            'CmsUserNoEmailExists' => 'CmsUser\Factory\Validator\NoEmailExistsValidatorFactory',
            'CmsUserNoUsernameExists' => 'CmsUser\Factory\Validator\NoUsernameExistsValidatorFactory',
            'CmsUserPasswordVerify' => 'CmsUser\Factory\Validator\PasswordVerifyValidatorFactory',
            'CmsUserUsername' => 'CmsUser\Factory\Validator\UsernameValidatorFactory',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'cmsUserDisplayName' => 'CmsUser\Factory\View\Helper\DisplayNameHelperFactory',
            'cmsUserUsername' => 'CmsUser\Factory\View\Helper\UsernameHelperFactory',
        ],
    ],
    'view_manager' => [
        'display_exceptions' => true,
        'template_map' => [
            'cms-user/navbar-menu' => __DIR__ . '/../view/cms-user/index/navbar-menu.phtml',
            'cms-user/authentication/reset-password-success'
                => __DIR__ . '/../view/cms-user/authentication/reset-password-success.phtml',
            'cms-user/authentication/reset-password-warning'
                => __DIR__ . '/../view/cms-user/authentication/reset-password-warning.phtml',
            'cms-user/authentication/reset-password'
                => __DIR__ . '/../view/cms-user/authentication/reset-password.phtml',
            'layout/cmsuser-footer' => __DIR__ . '/../view/layout/footer.phtml',
            'layout/cmsuser-header' => __DIR__ . '/../view/layout/header.phtml',
            'layout/cmsuser-layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/cmsuser-nav-menu' => __DIR__ . '/../view/layout/nav-menu.phtml',
            'layout/cmsuser-navbar-menu' => __DIR__ . '/../view/layout/navbar-menu.phtml',
            'layout/cmsuser-region-center' => __DIR__ . '/../view/layout/region-center.phtml',
            'layout/cmsuser-region-leading' => __DIR__ . '/../view/layout/region-leading.phtml',
            'layout/cmsuser-region-trailing' => __DIR__ . '/../view/layout/region-trailing.phtml',
            'mail-message/user-register' => __DIR__ . '/../view/mail-message/register.phtml',
            'mail-message/user-confirm-email' => __DIR__ . '/../view/mail-message/confirm-email.phtml',
            'mail-message/user-reset-password' => __DIR__ . '/../view/mail-message/reset-password.phtml',
            'mail-message/user-change-password-success'
                => __DIR__ . '/../view/mail-message/change-password-success.phtml',
        ],
        'template_path_stack' => [
            'CmsUser' => __DIR__ . '/../view',
        ],
    ],
];
