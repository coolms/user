<?php
// Generated by ZF2's ./bin/classmap_generator.php
return array(
    'CmsUser\Authentication\Adapter\DefaultAdapter'                => __DIR__ . '/src/Authentication/Adapter/DefaultAdapter.php',
    'CmsUser\Authentication\Storage\DefaultStorage'                => __DIR__ . '/src/Authentication/Storage/DefaultStorage.php',
    'CmsUser\Controller\AdminController'                           => __DIR__ . '/src/Controller/AdminController.php',
    'CmsUser\Controller\AuthenticationController'                  => __DIR__ . '/src/Controller/AuthenticationController.php',
    'CmsUser\Controller\IndexController'                           => __DIR__ . '/src/Controller/IndexController.php',
    'CmsUser\Controller\RegistrationController'                    => __DIR__ . '/src/Controller/RegistrationController.php',
    'CmsUser\Entity\Question'                                      => __DIR__ . '/src/Entity/Question.php',
    'CmsUser\Entity\Repository\QuestionRepository'                 => __DIR__ . '/src/Entity/Repository/QuestionRepository.php',
    'CmsUser\Entity\Repository\UserRepository'                     => __DIR__ . '/src/Entity/Repository/UserRepository.php',
    'CmsUser\Entity\Translations\QuestionTranslation'              => __DIR__ . '/src/Entity/Translations/QuestionTranslation.php',
    'CmsUser\Entity\User'                                          => __DIR__ . '/src/Entity/User.php',
    'CmsUser\Event\BlameableListener'                              => __DIR__ . '/src/Event/BlameableListener.php',
    'CmsUser\Event\RegistrationListener'                           => __DIR__ . '/src/Event/RegistrationListener.php',
    'CmsUser\Exception\DomainException'                            => __DIR__ . '/src/Exception/DomainException.php',
    'CmsUser\Exception\ExceptionInterface'                         => __DIR__ . '/src/Exception/ExceptionInterface.php',
    'CmsUser\Exception\InvalidArgumentException'                   => __DIR__ . '/src/Exception/InvalidArgumentException.php',
    'CmsUser\Factory\Authentication\AdapterFactory'                => __DIR__ . '/src/Factory/Authentication/AdapterFactory.php',
    'CmsUser\Factory\Authentication\StorageFactory'                => __DIR__ . '/src/Factory/Authentication/StorageFactory.php',
    'CmsUser\Factory\Controller\AuthenticationControllerFactory'   => __DIR__ . '/src/Factory/Controller/AuthenticationControllerFactory.php',
    'CmsUser\Factory\Controller\IndexControllerFactory'            => __DIR__ . '/src/Factory/Controller/IndexControllerFactory.php',
    'CmsUser\Factory\Controller\RegistrationControllerFactory'     => __DIR__ . '/src/Factory/Controller/RegistrationControllerFactory.php',
    'CmsUser\Factory\CryptoPasswordServiceFactory'                 => __DIR__ . '/src/Factory/CryptoPasswordServiceFactory.php',
    'CmsUser\Factory\Form\ChangeEmailFormFactory'                  => __DIR__ . '/src/Factory/Form/ChangeEmailFormFactory.php',
    'CmsUser\Factory\Form\ChangePasswordFormFactory'               => __DIR__ . '/src/Factory/Form/ChangePasswordFormFactory.php',
    'CmsUser\Factory\Form\ChangeSecurityQuestionFormFactory'       => __DIR__ . '/src/Factory/Form/ChangeSecurityQuestionFormFactory.php',
    'CmsUser\Factory\Form\EditProfileFormFactory'                  => __DIR__ . '/src/Factory/Form/EditProfileFormFactory.php',
    'CmsUser\Factory\Form\Element\BirthdayElementFactory'          => __DIR__ . '/src/Factory/Form/Element/BirthdayElementFactory.php',
    'CmsUser\Factory\Form\Element\BirthdayVerifyElementFactory'    => __DIR__ . '/src/Factory/Form/Element/BirthdayVerifyElementFactory.php',
    'CmsUser\Factory\Form\Element\IdentityElementDelegatorFactory' => __DIR__ . '/src/Factory/Form/Element/IdentityElementDelegatorFactory.php',
    'CmsUser\Factory\Form\RegisterFormFactory'                     => __DIR__ . '/src/Factory/Form/RegisterFormFactory.php',
    'CmsUser\Factory\Form\ResetPasswordFormFactory'                => __DIR__ . '/src/Factory/Form/ResetPasswordFormFactory.php',
    'CmsUser\Factory\ModuleOptionsFactory'                         => __DIR__ . '/src/Factory/ModuleOptionsFactory.php',
    'CmsUser\Factory\NavigationFactory'                            => __DIR__ . '/src/Factory/NavigationFactory.php',
    'CmsUser\Factory\Persistence\UserMapperDelegatorFactory'       => __DIR__ . '/src/Factory/Persistence/UserMapperDelegatorFactory.php',
    'CmsUser\Factory\UserServiceFactory'                           => __DIR__ . '/src/Factory/UserServiceFactory.php',
    'CmsUser\Factory\Validator\AnswerVerifyValidatorFactory'       => __DIR__ . '/src/Factory/Validator/AnswerVerifyValidatorFactory.php',
    'CmsUser\Factory\Validator\BirthdayValidatorFactory'           => __DIR__ . '/src/Factory/Validator/BirthdayValidatorFactory.php',
    'CmsUser\Factory\Validator\BirthdayVerifyValidatorFactory'     => __DIR__ . '/src/Factory/Validator/BirthdayVerifyValidatorFactory.php',
    'CmsUser\Factory\Validator\EmailAddressValidatorFactory'       => __DIR__ . '/src/Factory/Validator/EmailAddressValidatorFactory.php',
    'CmsUser\Factory\Validator\IdentityValidatorDelegatorFactory'  => __DIR__ . '/src/Factory/Validator/IdentityValidatorDelegatorFactory.php',
    'CmsUser\Factory\Validator\NoEmailExistsValidatorFactory'      => __DIR__ . '/src/Factory/Validator/NoEmailExistsValidatorFactory.php',
    'CmsUser\Factory\Validator\NoUsernameExistsValidatorFactory'   => __DIR__ . '/src/Factory/Validator/NoUsernameExistsValidatorFactory.php',
    'CmsUser\Factory\Validator\PasswordVerifyValidatorFactory'     => __DIR__ . '/src/Factory/Validator/PasswordVerifyValidatorFactory.php',
    'CmsUser\Factory\Validator\UsernameValidatorFactory'           => __DIR__ . '/src/Factory/Validator/UsernameValidatorFactory.php',
    'CmsUser\Factory\View\Helper\DisplayNameHelperFactory'         => __DIR__ . '/src/Factory/View/Helper/DisplayNameHelperFactory.php',
    'CmsUser\Factory\View\Helper\UsernameHelperFactory'            => __DIR__ . '/src/Factory/View/Helper/UsernameHelperFactory.php',
    'CmsUser\Form\Element\Birthday'                                => __DIR__ . '/src/Form/Element/Birthday.php',
    'CmsUser\Form\Element\BirthdayVerify'                          => __DIR__ . '/src/Form/Element/BirthdayVerify.php',
    'CmsUser\Form\Element\Email'                                   => __DIR__ . '/src/Form/Element/Email.php',
    'CmsUser\Form\Element\MobilePhoneNumber'                       => __DIR__ . '/src/Form/Element/MobilePhoneNumber.php',
    'CmsUser\Form\Element\Username'                                => __DIR__ . '/src/Form/Element/Username.php',
    'CmsUser\Form\ResetPassword'                                   => __DIR__ . '/src/Form/ResetPassword.php',
    'CmsUser\Initializer\UserServiceInitializer'                   => __DIR__ . '/src/Initializer/UserServiceInitializer.php',
    'CmsUser\Mapping\Blameable\BlameableInterface'                 => __DIR__ . '/src/Mapping/Blameable/BlameableInterface.php',
    'CmsUser\Mapping\Blameable\BlameableSubscriber'                => __DIR__ . '/src/Mapping/Blameable/BlameableSubscriber.php',
    'CmsUser\Mapping\Blameable\ChangeableInterface'                => __DIR__ . '/src/Mapping/Blameable/ChangeableInterface.php',
    'CmsUser\Mapping\Blameable\CreatableInterface'                 => __DIR__ . '/src/Mapping/Blameable/CreatableInterface.php',
    'CmsUser\Mapping\Blameable\Mapping\Driver\Annotation'          => __DIR__ . '/src/Mapping/Blameable/Mapping/Driver/Annotation.php',
    'CmsUser\Mapping\Blameable\Mapping\Event\Adapter\ORM'          => __DIR__ . '/src/Mapping/Blameable/Mapping/Event/Adapter/ORM.php',
    'CmsUser\Mapping\Blameable\Mapping\Event\BlameableAdapter'     => __DIR__ . '/src/Mapping/Blameable/Mapping/Event/BlameableAdapter.php',
    'CmsUser\Mapping\Blameable\Traits\BlameableTrait'              => __DIR__ . '/src/Mapping/Blameable/Traits/BlameableTrait.php',
    'CmsUser\Mapping\Blameable\Traits\ChangeableTrait'             => __DIR__ . '/src/Mapping/Blameable/Traits/ChangeableTrait.php',
    'CmsUser\Mapping\Blameable\Traits\CreatableTrait'              => __DIR__ . '/src/Mapping/Blameable/Traits/CreatableTrait.php',
    'CmsUser\Mapping\Blameable\Traits\UpdatableTrait'              => __DIR__ . '/src/Mapping/Blameable/Traits/UpdatableTrait.php',
    'CmsUser\Mapping\Blameable\UpdatableInterface'                 => __DIR__ . '/src/Mapping/Blameable/UpdatableInterface.php',
    'CmsUser\Mapping\LoginTrackableInterface'                      => __DIR__ . '/src/Mapping/LoginTrackableInterface.php',
    'CmsUser\Mapping\StateableInterface'                           => __DIR__ . '/src/Mapping/StateableInterface.php',
    'CmsUser\Mapping\Traits\UserableTrait'                         => __DIR__ . '/src/Mapping/Traits/UserableTrait.php',
    'CmsUser\Mapping\UserableInterface'                            => __DIR__ . '/src/Mapping/UserableInterface.php',
    'CmsUser\Mapping\UserInterface'                                => __DIR__ . '/src/Mapping/UserInterface.php',
    'CmsUser\Module'                                               => __DIR__ . '/src/Module.php',
    'CmsUser\Options\AuthenticationOptionsInterface'               => __DIR__ . '/src/Options/AuthenticationOptionsInterface.php',
    'CmsUser\Options\ControllerOptionsInterface'                   => __DIR__ . '/src/Options/ControllerOptionsInterface.php',
    'CmsUser\Options\FormOptionsInterface'                         => __DIR__ . '/src/Options/FormOptionsInterface.php',
    'CmsUser\Options\InputFilterOptionsInterface'                  => __DIR__ . '/src/Options/InputFilterOptionsInterface.php',
    'CmsUser\Options\ModuleOptions'                                => __DIR__ . '/src/Options/ModuleOptions.php',
    'CmsUser\Options\PasswordOptionsInterface'                     => __DIR__ . '/src/Options/PasswordOptionsInterface.php',
    'CmsUser\Options\UserServiceOptionsInterface'                  => __DIR__ . '/src/Options/UserServiceOptionsInterface.php',
    'CmsUser\Options\ViewHelperServiceOptionsInterface'            => __DIR__ . '/src/Options/ViewHelperServiceOptionsInterface.php',
    'CmsUser\Persistence\UserMapperInterface'                      => __DIR__ . '/src/Persistence/UserMapperInterface.php',
    'CmsUser\Service\UserService'                                  => __DIR__ . '/src/Service/UserService.php',
    'CmsUser\Service\UserServiceAwareInterface'                    => __DIR__ . '/src/Service/UserServiceAwareInterface.php',
    'CmsUser\Service\UserServiceAwareTrait'                        => __DIR__ . '/src/Service/UserServiceAwareTrait.php',
    'CmsUser\Service\UserServiceInterface'                         => __DIR__ . '/src/Service/UserServiceInterface.php',
    'CmsUser\View\Exception\DomainException'                       => __DIR__ . '/src/View/Exception/DomainException.php',
    'CmsUser\View\Helper\DisplayName'                              => __DIR__ . '/src/View/Helper/DisplayName.php',
    'CmsUser\View\Helper\Username'                                 => __DIR__ . '/src/View/Helper/Username.php',
    'CmsUserTest\Framework\TestCase'                               => __DIR__ . '/tests/Framework/TestCase.php',
    'CmsUserTest\SampleTest'                                       => __DIR__ . '/tests/SampleTest.php',
);
