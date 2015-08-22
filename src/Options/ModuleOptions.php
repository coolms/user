<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Options;

use Zend\Stdlib\AbstractOptions,
    CmsCommon\Form\Options\Traits\FormOptionsTrait;

class ModuleOptions extends AbstractOptions implements
    AuthenticationOptionsInterface,
    ControllerOptionsInterface,
    FormOptionsInterface,
    InputFilterOptionsInterface,
    UserServiceOptionsInterface,
    ViewHelperServiceOptionsInterface
{
    use FormOptionsTrait;

    /**
     * Turn off strict options mode
     *
     * @var bool
     */
    protected $__strictMode__ = false;

    /**
     * @var array
     */
    protected $identityFields = ['username', 'email'];

    /**
     * @var array
     */
    protected $allowedAuthenticationStates = [null, 1];

    /**
     * @var string
     */
    protected $authenticationService = 'Zend\\Authentication\\AuthenticationServiceInterface';

    /**
     * @var string
     */
    protected $defaultUserRoute = 'cms-user';

    /**
     * @var bool
     */
    protected $enableResetPassword = true;

    /**
     * @var bool
     */
    protected $enableRegistration = true;

    /**
     * @var bool
     */
    protected $useRegistrationRedirectParameter = true;

    /**
     * @var bool
     */
    protected $loginAfterRegistration = true;

    /**
     * @var string
     */
    protected $loginRoute = 'cms-user/login';

    /**
     * @var string
     */
    protected $authenticationController = 'CmsAuthentication\\Controller\\Authentication';

    /**
     * @var bool
     */
    protected $enableUsername = true;

    /**
     * @var int
     */
    protected $minUsernameLength = 4;

    /**
     * @var int
     */
    protected $maxUsernameLength = 60;

    /**
     * @var string
     */
    protected $usernameRegexPattern = '/^[a-zA-Z0-9\.\_\-]+$/ui';

    /**
     * @var string
     */
    protected $passwordService = 'Zend\\Crypt\\Password\\PasswordInterface';

    /**
     * @var int
     */
    protected $minPasswordLength = 6;

    /**
     * @var int
     */
    protected $maxPasswordLength = 30;

    /**
     * @var int
     */
    protected $passwordCost = 10;

    /**
     * @var string
     */
    protected $userEntityClass = 'CmsUser\\Mapping\\UserInterface';

    /**
     * @var int
     */
    protected $defaultUserState = 1;

    /**
     * @var string
     */
    protected $passwordGeneratorService = 'CmsCommon\\Crypt\\PasswordGeneratorInterface';

    /**
     * @var string
     */
    protected $mailService = 'CmsMailer\\Service\\MailServiceInterface';

    /**
     * @var string
     */
    protected $senderEmailAddress = 'no-reply@example.com';

    /**
     * @var string
     */
    protected $senderName;

    /**
     * @var bool
     */
    protected $enableDisplayName = true;

    /** @see \CmsUser\Options\AuthenticationOptionsInterface */

    /**
     * {@inheritDoc}
     */
    public function setIdentityFields($identityFields)
    {
        $this->identityFields = (array) $identityFields;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentityFields()
    {
        if (!$this->getEnableUsername()
            && in_array('username', $this->identityFields)
            && ($keys = array_keys($this->identityFields, 'username'))
        ) {
            foreach ($keys as $key) {
                unset($this->identityFields[$key]);
            }
        }

        return $this->identityFields;
    }

    /**
     * {@inheritDoc}
     */
    public function setAllowedAuthenticationStates($states)
    {
        $this->allowedAuthenticationStates = (array) $states;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAllowedAuthenticationStates()
    {
        return $this->allowedAuthenticationStates;
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthenticationService($service)
    {
        $this->authenticationService = $service;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthenticationService()
    {
        return $this->authenticationService;
    }

    /** @see \CmsUser\Options\ControllerOptionsInterface */

    /**
     * {@inheritDoc}
     */
    public function setDefaultUserRoute($route)
    {
        $this->defaultUserRoute = $route;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultUserRoute()
    {
        return $this->defaultUserRoute;
    }

    /**
     * {@inheritDoc}
     */
    public function setEnableResetPassword($flag)
    {
        $this->enableResetPassword = $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnableResetPassword()
    {
        return $this->enableResetPassword;
    }

    /**
     * {@inheritDoc}
     */
    public function setEnableRegistration($flag)
    {
        $this->enableRegistration = (bool) $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnableRegistration()
    {
        return $this->enableRegistration;
    }

    /**
     * {@inheritDoc}
     */
    public function setUseRegistrationRedirectParameter($flag)
    {
        $this->useRegistrationRedirectParameter = (bool) $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUseRegistrationRedirectParameter()
    {
        return $this->useRegistrationRedirectParameter;
    }

    /**
     * {@inheritDoc}
     */
    public function setLoginAfterRegistration($flag)
    {
        $this->loginAfterRegistration = (bool) $flag;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLoginAfterRegistration()
    {
        return $this->loginAfterRegistration;
    }

    /**
     * {@inheritDoc}
     */
    public function setLoginRoute($route)
    {
        $this->loginRoute = $route;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLoginRoute()
    {
        return $this->loginRoute;
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthenticationController($controller)
    {
        $this->authenticationController = $controller;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAuthenticationController()
    {
        return $this->authenticationController;
    }

    /** @see \CmsUser\Options\FormOptionsInterface */

    /**
     * {@inheritDoc}
     */
    public function setEnableUsername($enableUsername)
    {
        $this->enableUsername = (bool) $enableUsername;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnableUsername()
    {
        return $this->enableUsername;
    }

    /** @see \CmsUser\Options\InputFilterOptionsInterface */

    /**
     * {@inheritDoc}
     */
    public function setPasswordService($passwordService)
    {
        $this->passwordService = $passwordService;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPasswordService()
    {
        return $this->passwordService;
    }

    /**
     * {@inheritDoc}
     */
    public function setMinUsernameLength($length)
    {
        $this->minUsernameLength = (int) $length;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMinUsernameLength()
    {
        return $this->minUsernameLength;
    }

    /**
     * {@inheritDoc}
     */
    public function setMaxUsernameLength($length)
    {
        $this->maxUsernameLength = (int) $length;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMaxUsernameLength()
    {
        return $this->maxUsernameLength;
    }

    /**
     * {@inheritDoc}
     */
    public function setUsernameRegexPattern($pattern)
    {
        $this->usernameRegexPattern = (string) $pattern;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsernameRegexPattern()
    {
        return $this->usernameRegexPattern;
    }

    /** @see \CmsUser\Options\PasswordOptionsInterface */

    /**
     * {@inheritDoc}
     */
    public function setMinPasswordLength($length)
    {
        $this->minPasswordLength = (int) $length;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMinPasswordLength()
    {
        return $this->minPasswordLength;
    }

    /**
     * {@inheritDoc}
     */
    public function setMaxPasswordLength($length)
    {
        $this->maxPasswordLength = (int) $length;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMaxPasswordLength()
    {
        return $this->maxPasswordLength;
    }

    /**
     * {@inheritDoc}
     */
    public function setPasswordCost($cost)
    {
        $this->passwordCost = (int) $cost;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPasswordCost()
    {
        return $this->passwordCost;
    }

    /** @see \CmsUser\Options\UserServiceOptionsInterface */

    /**
     * {@inheritDoc}
     */
    public function setUserEntityClass($className)
    {
        $this->userEntityClass = (string) $className;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserEntityClass()
    {
        return $this->userEntityClass;
    }

    /**
     * {@inheritDoc}
     */
    public function setDefaultUserState($state)
    {
        $this->defaultUserState = $state;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getDefaultUserState()
    {
        return $this->defaultUserState;
    }

    /**
     * {@inheritDoc}
     */
    public function setPasswordGeneratorService($service)
    {
        $this->passwordGeneratorService = $service;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPasswordGeneratorService()
    {
        return $this->passwordGeneratorService;
    }

    /**
     * {@inheritDoc}
     */
    public function setMailService($service)
    {
        $this->mailService = (string) $service;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMailService()
    {
        return $this->mailService;
    }

    /**
     * {@inheritDoc}
     */
    public function setSenderEmailAddress($senderEmailAddress)
    {
        $this->senderEmailAddress = $senderEmailAddress;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSenderEmailAddress()
    {
        return $this->senderEmailAddress;
    }

    /**
     * Set sender name.
     * 
     * @param string $senderName
     * @return self
     */
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
        return $this;
    }

    /**
     * Get sender name.
     * 
     * @return string
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /** @see \CmsUser\Options\ViewHelperOptionsInterface */

    /**
     * {@inheritDoc}
     */
    public function setEnableDisplayName($enableDisplayName)
    {
        $this->enableDisplayName = (bool) $enableDisplayName;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getEnableDisplayName()
    {
        return $this->enableDisplayName;
    }
}
