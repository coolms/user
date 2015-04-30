<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Service;

use Zend\Form\FormInterface,
    CmsCommon\Service\DomainServiceInterface,
    CmsUser\Mapping\UserInterface;

/**
 * User service interface
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface UserServiceInterface extends DomainServiceInterface
{
    /**
     * Register user
     *
     * @param UserInterface|array $data
     * @return UserInterface|bool
     */
    public function register($data);

    /**
     * Retrieves user registration form
     *
     * @return FormInterface
     */
    public function getRegisterForm();

    /**
     * Edit user profile
     *
     * @param UserInterface|array $data
     * @return UserInterface|void
     */
    public function editProfile($data);

    /**
     * Retrieves form for editing user profile
     *
     * @return FormInterface
     */
    public function getEditProfileForm();

    /**
     * Confirm user email
     *
     * @param string $token
     * @return UserInterface|void
     */
    public function confirmEmail($token);

    /**
     * Change user password
     *
     * @param array|UserInterface $data
     * @return UserInterface|void
     */
    public function changePassword($data);

    /**
     * Retrieves form for changing user password
     *
     * @return FormInterface
     */
    public function getChangePasswordForm();

    /**
     * Reset user password
     *
     * @param mixed $identity
     * @return UserInterface|void
     */
    public function resetPassword($identity);

    /**
     * Retrieves form for reseting user password
     *
     * @return FormInterface
     */
    public function getResetPasswordForm();

    /**
     * Password reset confirmation method
     *
     * @param string $token
     * @param UserInterface|void
     */
    public function confirmPasswordReset($token);

    /**
     * Change user email
     *
     * @param array|UserInterface $data
     * @return UserInterface|void
     */
    public function changeEmail($data);

    /**
     * Retrieves form for changing user email
     *
     * @return FormInterface
     */
    public function getChangeEmailForm();

    /**
     * Change user security question
     *
     * @param array|UserInterface $data
     * @return UserInterface|void
     */
    public function changeSecurityQuestion($data);

    /**
     * Retrieves form for changing user email
     *
     * @return FormInterface
     */
    public function getChangeSecurityQuestionForm();
}
