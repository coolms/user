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

interface PasswordOptionsInterface
{
    /**
     * @param string $passwordService
     * @return self
     */
    public function setPasswordService($passwordService);

    /**
     * @return string
     */
    public function getPasswordService();

    /**
     * Set minimum password length.
     *
     * @param int $length
     * @return self
     */
    public function setMinPasswordLength($length);

    /**
     * Get minimum password length.
     *
     * @return int
     */
    public function getMinPasswordLength();

    /**
     * Set maximum password length.
     *
     * @param int $length
     * @return self
     */
    public function setMaxPasswordLength($length);

    /**
     * Get maximum password length.
     *
     * @return int
     */
    public function getMaxPasswordLength();

    /**
     * Set password cost.
     *
     * @param int $passwordCost
     * @return self
     */
    public function setPasswordCost($cost);

    /**
     * Get password cost.
     *
     * @return int
     */
    public function getPasswordCost();
}
