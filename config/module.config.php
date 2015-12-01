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
                    ['route' => 'cms-admin/user/profile', 'roles' => ['admin']],

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
        'aliases' => [
            'CmsUser\Controller\User' => 'CmsUser\Mapping\UserInterface',
        ],
        'factories' => [
            'CmsUser\Controller\Authentication'
                => 'CmsUser\Factory\Mvc\Controller\AuthenticationControllerFactory',
            'CmsUser\Controller\Index'
                => 'CmsUser\Factory\Mvc\Controller\IndexControllerFactory',
            'CmsUser\Controller\Registration'
                => 'CmsUser\Factory\Mvc\Controller\RegistrationControllerFactory',
        ],
        'invokables' => [
            'CmsUser\Controller\Admin' => 'CmsUser\Mvc\Controller\AdminController',
        ],
    ],
    'domain_services' => [
        'aliases' => [
            'CmsUser\Mapping\UserInterface' => 'CmsUser\Service\UserServiceInterface',
            'CmsUser\Service\UserServiceInterface' => 'CmsUser\Service\UserService',
        ],
        'factories' => [
            'CmsUser\Service\UserService' => 'CmsUser\Factory\UserServiceFactory',
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
        'CmsUser\Listener\RegistrationListener' => 'CmsUser\Listener\RegistrationListener',
    ],
    'mappers' => [
        'aliases' => [
            'CmsUser\Mapping\UserInterface' => 'CmsUser\Persistence\UserMapperInterface',
        ],
        'delegators' => [
            'CmsUser\Persistence\UserMapperInterface'
                => ['CmsUser\Factory\Persistence\UserMapperDelegatorFactory'],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'CmsUser\Options\ModuleOptionsInterface' => 'CmsUser\Options\ModuleOptions',
        ],
        'invokables' => [
            'CmsUser\Listener\RegistrationListener' => 'CmsUser\Listener\RegistrationListener',
            'CmsUser\MailService' => 'CmsMailer\Service\MailService',
        ],
        'factories' => [
            'Zend\Authentication\Storage\StorageInterface'
                => 'CmsUser\Factory\Authentication\StorageFactory',
            'Zend\Crypt\Password\PasswordInterface'
                => 'CmsUser\Factory\CryptoPasswordServiceFactory',
            'CmsUser\Authentication\Adapter\DefaultAdapter'
                => 'CmsUser\Factory\Authentication\AdapterFactory',
            'CmsUser\Options\ModuleOptions' => 'CmsUser\Factory\ModuleOptionsFactory',
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
            'CmsAuthenticationIdentity'
                => ['CmsUser\Factory\Validator\IdentityValidatorDelegatorFactory'],
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
        'template_map' => [
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
