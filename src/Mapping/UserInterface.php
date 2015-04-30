<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Mapping;

use CmsCommon\Mapping\Common\PasswordableInterface,
    CmsCommon\Mapping\Dateable\ExpirableInterface;

/**
 * User entity interface
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface UserInterface extends StateableInterface, ExpirableInterface, PasswordableInterface
{
    /**
     * Retrieves id
     *
     * @return number
     */
    public function getId();

    /**
     * Retrieves username
     *
     * @return string
     */
    public function getUsername();

    /**
     * Sets username
     *
     * @param string $username
     */
    public function setUsername($username);

    /**
     * Retrieves email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Sets email address
     *
     * @param string $email
     */
    public function setEmail($email);

    /**
     * Sets whether email is confirmed
     *
     * @param bool $flag
     */
    public function setEmailConfirmed($flag);

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday();

    /**
     * Retrieves user mobile phone number
     *
     * @return string
     */
    public function getMobilePhoneNumber();

    /**
     * Get display name
     *
     * @return string
     */
    public function getDisplayName();

    /**
     * Get question
     *
     * @return Question
     */
    public function getQuestion();

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer();

    /**
     * Set registration token
     *
     * @param string $token
     */
    public function setRegistrationToken($token);

    /**
     * Get registration token
     *
     * @return string
     */
    public function getRegistrationToken();
}
