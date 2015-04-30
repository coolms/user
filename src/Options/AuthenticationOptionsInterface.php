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

interface AuthenticationOptionsInterface
{
    /**
     * Set authentication identity fields.
     *
     * @param array $identityFields
     * @return self
     */
    public function setIdentityFields($identityFields);

    /**
     * Get authentication identity fields.
     *
     * @return array
     */
    public function getIdentityFields();

    /**
     * Set list of states to allow user authentication.
     *
     * @param array $states
     * @return self
     */
    public function setAllowedAuthenticationStates($states);

    /**
     * Get list of states to allow user authentication.
     *
     * @return array
     */
    public function getAllowedAuthenticationStates();

    /**
     * Set authentication service
     *
     * @param string $service
     * @return self
     */
    public function setAuthenticationService($service);

    /**
     * Get authentication service
     *
     * @return string
     */
    public function getAuthenticationService();
}
