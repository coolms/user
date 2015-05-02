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

interface InputFilterOptionsInterface extends PasswordOptionsInterface
{
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
     * Set minimum username length.
     *
     * @param int $length
     * @return self
     */
    public function setMinUsernameLength($length);

    /**
     * Get minimum username length.
     *
     * @return int
     */
    public function getMinUsernameLength();

    /**
     * Set maximum username length.
     *
     * @param int $length
     * @return self
     */
    public function setMaxUsernameLength($length);

    /**
     * Get maximum identity length.
     *
     * @return int
     */
    public function getMaxUsernameLength();

    /**
     * Set username regex pattern.
     *
     * @param string $pattern
     * @return self
     */
    public function setUsernameRegexPattern($pattern);

    /**
     * Get username regex pattern.
     *
     * @return string
     */
    public function getUsernameRegexPattern();

    /**
     * Get authentication service
     *
     * @return string
     */
    public function getAuthenticationService();

    /**
     * Get authentication identity fields.
     *
     * @return array
     */
    public function getIdentityFields();

    /**
     * Get user entity class name.
     *
     * @return string
     */
    public function getUserEntityClass();
}
