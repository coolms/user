<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

/**
 * RU-Revision: 18.Apr.2015
 */
return [

    // CmsUser\Authentication\Adapter\DefaultAdapter
    "A record with the supplied identity is disabled" => "Учетная запись заблокирована",
    "Record has expired" => "Учетная запись истекла",
    "Authentication successful" => "Аутентификация прошла успешно",

    // CmsUser\Factory\Validator\AnswerVerifyValidatorFactory
    "Your answer is wrong. Please provide the correct answer" => "Неверный ответ. Пожалуйста, введите верный ответ на вопрос",

    // CmsUser\Factory\Validator\BirthdayValidatorFactory
    "The date of birth must be not earlier than %min% inclusive" => "Дата рождения должна быть не ранее %min% включительно",
    "The date of birth must be not later than %max% inclusive" => "Дата рождения должна быть не позднее %max% включительно",

    // CmsUser\Factory\Validator\BirthdayVerifyValidatorFactory
    "Your birthday is wrong. Please provide the correct birthday" => "Неверная дата рождения. Пожалуйста, введите правильную дату",

    // CmsUser\Factory\Validator\EmailValidatorFactory
    "Email address must be at least %min% characters long" => "Адрес эл.почты должен быть не менее %min% символов",
    "Email address must not be more than %max% characters" => "Адрес эл.почты должен быть не более %max% символов",

    // CmsUser\Factory\Validator\IdentityValidatorDelegatorFactory
    "A record with the supplied identity could not be found" => "Пользователь с такой учетной записью не найден",
    "Incorrect identity. Identity must contain alphanumeric characters without spaces" => "Неверная учетная запись. Учетная запись должна состоять из латинских символов или цифр без пробелов",

    // CmsUser\Factory\Validator\NoEmailExistsValidatorFactory
    "An user with this email already exists" => "Пользователь с таким адресом эл.почты уже существует",

    // CmsUser\Factory\Validator\NoUsernameValidatorFactory
    "This username is already taken" => "Пользователь с таким именем уже существует",

    // CmsUser\Factory\Validator\PasswordValidatorFactory
    "Incorrect password verification" => "Неверное подтверждение пароля",
    "Supplied credential is invalid" => "Неверный пароль",

    // CmsUser\Factory\Validator\UsernameValidatorFactory
    "The username must be at least %min% characters long" => "Имя пользователя должно быть не менее %min% символов",
    "The username must not be more than %max% characters" => "Имя пользователя должно быть не более %max% символов",
    "Incorrect username. Username must contain alphanumeric characters without spaces" => "Неверное имя пользователя. Имя пользователя должно состоять из латинских символов или цифр без пробелов",
    
    // CmsUser\Form\ChangePassword
    "The passwords are not the same" => "Пароли не совпадают",

    // CmsUser\Entity\User
    "The password must be at least %min% characters long" => "Пароль должен быть не менее %min% символов",
    "The password must not be more than %max% characters" => "Пароль должен быть не более %max% символов",
    "The answer must be at least %min% characters long" => "Ответ должен быть не менее %min% символов",
    "The answer must not be more than %max% characters" => "Ответ должен быть не более %max% символов",
];
