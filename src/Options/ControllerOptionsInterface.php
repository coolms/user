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

interface ControllerOptionsInterface
{
    /**
     * Get authentication identity fields.
     *
     * @return array
     */
    public function getIdentityFields();

    /**
     * Set default user route
     *
     * @param string $route
     * @return self
     */
    public function setDefaultUserRoute($route);

    /**
     * Get default user route
     *
     * @return string
     */
    public function getDefaultUserRoute();

    /**
     * Set enable user reset password
     *
     * @param bool $flag
     * @return self
     */
    public function setEnableResetPassword($flag);

    /**
     * Get enable user reset password
     *
     * @return bool
     */
    public function getEnableResetPassword();

    /**
     * Set enable user registration
     *
     * @param bool $flag
     * @return self
     */
    public function setEnableRegistration($flag);

    /**
     * Get enable user registration
     *
     * @return bool
     */
    public function getEnableRegistration();

    /**
     * Set use registration redirect parameter.
     *
     * @param bool $flag
     * @return self
     */
    public function setUseRegistrationRedirectParameter($flag);

    /**
     * Get use registration redirect parameter.
     *
     * @return bool
     */
    public function getUseRegistrationRedirectParameter();

    /**
     * Set login after registration.
     *
     * @param bool $flag
     * @return self
     */
    public function setLoginAfterRegistration($flag);

    /**
     * Get login after registration.
     *
     * @return bool
     */
    public function getLoginAfterRegistration();

    /**
     * @param string $route
     * @return self
     */
    public function setLoginRoute($route);

    /**
     * @return string
     */
    public function getLoginRoute();

    /**
     * Set authentication controller class name
     *
     * @param string $controller
     * @return self
     */
    public function setAuthenticationController($controller);

    /**
     * Retrieves authentication controller class name
     *
     * @return string
     */
    public function getAuthenticationController();

    /**
     * Set enable username.
     *
     * @param bool $flag
     * @return self
     */
    public function setEnableUsername($flag);

    /**
     * Get enable username.
     *
     * @return bool
     */
    public function getEnableUsername();

    /**
     * Get user entity class name.
     *
     * @return string
     */
    public function getUserEntityClass();
}
