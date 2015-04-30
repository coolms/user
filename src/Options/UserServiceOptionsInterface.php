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

interface UserServiceOptionsInterface
{
    /**
     * Set user entity class name.
     *
     * @param string $class
     * @return self
     */
    public function setClassName($class);

    /**
     * Get user entity class name.
     *
     * @return string
     */
    public function getClassName();

    /**
     * Set default user state on registration.
     *
     * @param int $state
     * @return self
     */
    public function setDefaultUserState($state);

    /**
     * Get default user state on registration.
     *
     * @return int
     */
    public function getDefaultUserState();

    /**
     * Set password generator service class name
     *
     * @param string $service
     * @return self
     */
    public function setPasswordGeneratorService($service);

    /**
     * Get password generator service class name
     *
     * @return string
     */
    public function getPasswordGeneratorService();

    /**
     * Set user mail service class name
     *
     * @param string $service
     * @return self
     */
    public function setMailService($service);

    /**
     * Get user mail service class name
     *
     * @return string
     */
    public function getMailService();

    /**
     * Set sender email address.
     *
     * @param string $senderEmailAddress
     * @return self
     */
    public function setSenderEmailAddress($senderEmailAddress);

    /**
     * Get sender email address.
     *
     * @return string
     */
    public function getSenderEmailAddress();

    /**
     * Set sender name.
     *
     * @param string $senderName
     * @return self
     */
    public function setSenderName($senderName);

    /**
     * Get sender name.
     *
     * @return string
     */
    public function getSenderName();
}
