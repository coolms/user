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
    Zend\I18n\Translator\TranslatorAwareInterface,
    Zend\I18n\Translator\TranslatorAwareTrait,
    Zend\ServiceManager\ServiceManager,
    Zend\View\Model\ViewModel,
    CmsCommon\Crypt\PasswordGeneratorInterface,
    CmsCommon\Mapping\Common\PasswordableInterface,
    CmsCommon\Mapping\Common\StateableInterface,
    CmsCommon\Persistence\MapperInterface,
    CmsCommon\Service\DomainService,
    CmsMailer\Service\MailServiceAwareTrait,
    CmsMailer\Service\MailServiceInterface,
    CmsUser\Mapping\UserInterface,
    CmsUser\Options\UserServiceOptionsInterface,
    CmsUser\Persistence\UserMapperInterface;

/**
 * User service
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 *
 * @method UserMapperInterface getMapper() Retrieves user mapper
 */
class UserService extends DomainService implements
        UserServiceInterface,
        TranslatorAwareInterface
{
    use MailServiceAwareTrait,
        TranslatorAwareTrait;

    /**
     * @var FormInterface
     */
    protected $registerForm;

    /**
     * @var FormInterface
     */
    protected $editProfileForm;

    /**
     * @var FormInterface
     */
    protected $changePasswordForm;

    /**
     * @var FormInterface
     */
    protected $resetPasswordForm;

    /**
     * @var FormInterface
     */
    protected $changeEmailForm;

    /**
     * @var FormInterface
     */
    protected $changeSecurityQuestionForm;

    /**
     * @var PasswordGeneratorInterface
     */
    protected $passwordGenerator;

    /**
     * {@inheritDoc}
     *
     * @param PasswordGeneratorInterface $passwordGenerator
     * @param MailServiceInterface $mailService
     */
    public function __construct(
        UserServiceOptionsInterface $options,
        ServiceManager $manager,
        PasswordGeneratorInterface $passwordGenerator,
        MailServiceInterface $mailService
    ) {
        $this->setClassName($options->getUserEntityClass());
        parent::__construct($options, $manager);
        $this->setPasswordGenerator($passwordGenerator);
        $this->setMailService($mailService);
    }

    /**
     * Register user
     *
     * @param array|UserInterface $data
     * @return UserInterface|void
     */
    public function register($data)
    {
        /* @var $user UserInterface */
        if (!($user = $this->hydrate($data, $this->getRegisterForm()))) {
            return;
        }

        $eventManager = $this->getEventManager();
        $eventManager->trigger(__FUNCTION__, $this, compact('user'));

        if ($user instanceof StateableInterface) {
            $user->setState($this->getOption('default_user_state'));
        }

        $user->setRegistrationToken($this->getRegistrationToken());

        if ($user instanceof PasswordableInterface) {
            $cryptoService = $this->getMapper()->getPasswordService();
            $password = $cryptoService->create($user->getPassword());
            $user->setPassword($password);
        }

        $viewModel = new ViewModel(compact('user'));
        $viewModel->setTemplate('mail-message/user-register');

        $mailService = $this->getMailService();
        $message = $mailService->getMessage();
        $message->setTo($user->getEmail(), $user->getDisplayName());

        $subject = 'Please, complete your registration!';
        if ($this->getTranslator() && $this->isTranslatorEnabled()) {
            $subject = $this->getTranslator()->translate(
                $subject,
                $this->getTranslatorTextDomain()
            );
        }
        $message->setSubject($subject);

        $mailService->setBody($viewModel)->sendMessage();

        $this->getMapper()->add($user)->save();

        $eventManager->trigger(__FUNCTION__ . '.post', $this, compact('user'));

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getRegisterForm()
    {
        if (null === $this->registerForm) {
            $sm = $this->getServiceLocator();
            $this->setRegisterForm($sm->getServiceLocator()
                ->get($this->formElementManager)->get('CmsUser\\Form\\Register'));
        }

        return $this->registerForm;
    }

    /**
     * @param FormInterface $form
     * @return self
     */
    public function setRegisterForm(FormInterface $form)
    {
        $this->registerForm = $form;
        return $this;
    }

    /**
     * Edit user profile
     *
     * @param array|UserInterface $data
     * @return UserInterface|void
     */
    public function editProfile($data)
    {
        /* @var $user UserInterface */
        if (!($user = $this->hydrate($data, $this->getEditProfileForm()))) {
            return;
        }

    	$eventManager = $this->getEventManager();
    	$eventManager->trigger(__FUNCTION__, $this, compact('user'));

    	$this->getMapper()->update($user)->save();

    	$eventManager->trigger(__FUNCTION__ . '.post', $this, compact('user'));

    	return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getEditProfileForm()
    {
        if (null === $this->editProfileForm) {
            $sm = $this->getServiceLocator();
            $this->setEditProfileForm($sm->getServiceLocator()
                ->get($this->formElementManager)->get('CmsUser\\Form\\EditProfile'));
        }

        return $this->editProfileForm;
    }

    /**
     * @param FormInterface $form
     * @return self
     */
    public function setEditProfileForm(FormInterface $form)
    {
        $this->editProfileForm = $form;
        return $this;
    }

    /**
     * Confirm user email
     *
     * @param string $token
     * @return UserInterface|void
     */
    public function confirmEmail($token)
    {
        /* @var $user UserInterface */
        $user = $this->getMapper()->findOneBy(['registrationToken' => $token]);
        if (!$user instanceof UserInterface) {
            return;
        }

        $eventManager = $this->getEventManager();
        $eventManager->trigger(__METHOD__, $this, $user);

        $user->setRegistrationToken($this->getRegistrationToken());
        $user->setEmailConfirmed(true);
        $this->getMapper()->update($user)->save();

        $eventManager->trigger(__METHOD__ . '.post', $this, $user);

        return $user;
    }

    /**
     * Change user password
     *
     * @param array|UserInterface $data
     * @return UserInterface|void
     */
    public function changePassword($data)
    {
        /* @var $user UserInterface */
        if (!($user = $this->hydrate($data, $this->getChangePasswordForm()))) {
            return;
        }

        $eventManager = $this->getEventManager();
        $eventManager->trigger(__METHOD__, $this, $user);

        $password = $user->getPassword();
        $passwordService = $this->getMapper()->getPasswordService();
        $user->setPassword($passwordService->create($password));
        $this->getMapper()->update($user)->save();

        $eventManager->trigger(__METHOD__ . '.post', $this, $user);

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getChangePasswordForm()
    {
        if (null === $this->changePasswordForm) {
            $sm = $this->getServiceLocator();
            $this->setChangePasswordForm($sm->getServiceLocator()
                ->get($this->formElementManager)->get('CmsUser\\Form\\ChangePassword'));
        }

        return $this->changePasswordForm;
    }

    /**
     * @param FormInterface $form
     * @return self
     */
    public function setChangePasswordForm(FormInterface $form)
    {
        $this->changePasswordForm = $form;
        return $this;
    }

    /**
     * Reset user password
     *
     * @param mixed $identity
     * @return UserInterface|void
     */
    public function resetPassword($identity)
    {
        $user = $this->getMapper()->findByIdentity($identity);
        if (!$user instanceof UserInterface) {
            return;
        }

        $eventManager = $this->getEventManager();
        $eventManager->trigger(__METHOD__, $this, $user);

        $user->setRegistrationToken($this->getRegistrationToken());

        $viewModel = new ViewModel(compact('user'));
        $viewModel->setTemplate('mail-message/user-reset-password');

        $mailService = $this->getMailService();
        $message = $mailService->getMessage();
        $message->setTo($user->getEmail(), $user->getDisplayName());

        $subject = 'Please, confirm your request to change password!';
        if ($this->getTranslator() && $this->isTranslatorEnabled()) {
            $subject = $this->getTranslator()->translate(
                $subject,
                $this->getTranslatorTextDomain()
            );
        }
        $message->setSubject($subject);

        $mailService->setBody($viewModel)->sendMessage();

        $this->getMapper()->update($user)->save();

        $eventManager->trigger(__METHOD__ . '.post', $this, $user);

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getResetPasswordForm()
    {
        if (null === $this->resetPasswordForm) {
            $sm = $this->getServiceLocator();
            $this->setResetPasswordForm($sm->getServiceLocator()
                ->get($this->formElementManager)->get('CmsUser\\Form\\ResetPassword'));
        }

        return $this->resetPasswordForm;
    }

    /**
     * @param FormInterface $form
     * @return self
     */
    public function setResetPasswordForm(FormInterface $form)
    {
        $this->resetPasswordForm = $form;
        return $this;
    }

    /**
     * Password reset confirmation method
     *
     * @param string $token
     * @param UserInterface|void
     */
    public function confirmPasswordReset($token)
    {
        $user = $this->getMapper()->findOneBy(['registrationToken' => $token]);
        if (!$user instanceof UserInterface) {
            return;
        }

        $eventManager = $this->getEventManager();
        $eventManager->trigger(__METHOD__, $this, $user);

        $user->setRegistrationToken($this->getRegistrationToken());
        $user->setEmailConfirmed(true);

        $password = $this->getPasswordGenerator()->generate();
        $passwordService = $this->getMapper()->getPasswordService();
        $user->setPassword($passwordService->create($password));

        $viewModel = new ViewModel(compact('user', 'password'));
        $viewModel->setTemplate('mail-message/user-change-password-success');

        $mailService = $this->getMailService();
        $message = $mailService->getMessage();
        $message->setTo($user->getEmail(), $user->getDisplayName());

        $subject = 'Your password has been changed!';
        if ($this->getTranslator() && $this->isTranslatorEnabled()) {
            $subject = $this->getTranslator()->translate(
                $subject,
                $this->getTranslatorTextDomain()
            );
        }
        $message->setSubject($subject);

        $mailService->setBody($viewModel)->sendMessage();

        $this->getMapper()->update($user)->save();

        $eventManager->trigger(__METHOD__ . '.post', $this, $user);

        return $user;
    }

    /**
     * Change user email
     *
     * @param array|UserInterface $data
     * @return UserInterface|void
     */
    public function changeEmail($data)
    {
        /* @var $user UserInterface */
        if (!($user = $this->hydrate($data, $this->getChangeEmailForm()))) {
            return;
        }

        $eventManager = $this->getEventManager();
        $eventManager->trigger(__METHOD__, $this, $user);

        $user->setEmailConfirmed(false);

        $viewModel = new ViewModel(compact('user'));
        $viewModel->setTemplate('mail-message/user-confirm-email');

        $mailService = $this->getMailService();
        $message = $mailService->getMessage();
        $message->setTo($user->getEmail(), $user->getDisplayName());

        $subject = 'Please, confirm your email!';
        if ($this->getTranslator() && $this->isTranslatorEnabled()) {
            $subject = $this->getTranslator()->translate(
                $subject,
                $this->getTranslatorTextDomain()
            );
        }
        $message->setSubject($subject);

        $mailService->setBody($viewModel)->sendMessage();

        $this->getMapper()->update($user)->save();

        $eventManager->trigger(__METHOD__ . '.post', $this, $user);

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getChangeEmailForm()
    {
        if (null === $this->changeEmailForm) {
            $sm = $this->getServiceLocator();
            $this->setChangeEmailForm($sm->getServiceLocator()
                ->get($this->formElementManager)->get('CmsUser\\Form\\ChangeEmail'));
        }

        return $this->changeEmailForm;
    }

    /**
     * @param FormInterface $form
     * @return self
     */
    public function setChangeEmailForm(FormInterface $form)
    {
        $this->changeEmailForm = $form;
        return $this;
    }

    /**
     * Change user security question
     *
     * @param array|UserInterface $data
     * @return UserInterface|void
     */
    public function changeSecurityQuestion($data)
    {
        /* @var $user UserInterface */
        if (!($user = $this->hydrate($data, $this->getChangeSecurityQuestionForm()))) {
            return;
        }

        $eventManager = $this->getEventManager();
        $eventManager->trigger(__METHOD__, $this, $user);

        $this->getMapper()->update($user)->save();

        $eventManager->trigger(__METHOD__ . '.post', $this, $user);

        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getChangeSecurityQuestionForm()
    {
        if (null === $this->changeSecurityQuestionForm) {
            $sm = $this->getServiceLocator();
            $this->setChangeSecurityQuestionForm($sm->getServiceLocator()
                ->get($this->formElementManager)->get('CmsUser\\Form\\ChangeSecurityQuestion'));
        }

        return $this->changeSecurityQuestionForm;
    }

    /**
     * @param FormInterface $form
     * @return self
     */
    public function setChangeSecurityQuestionForm(FormInterface $form)
    {
        $this->changeSecurityQuestionForm = $form;
        return $this;
    }

    /**
     * @return PasswordGeneratorInterface
     */
    public function getPasswordGenerator()
    {
        return $this->passwordGenerator;
    }

    /**
     * @param PasswordGeneratorInterface $generator
     * @return self
     */
    public function setPasswordGenerator(PasswordGeneratorInterface $generator)
    {
        $this->passwordGenerator = $generator;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setMapper(MapperInterface $mapper)
    {
        if (!$mapper instanceof UserMapperInterface) {
            throw new \InvalidArgumentException(sprintf(
                'First argument must implement CmsUser\Persistence\UserMapperInterface; %s given',
                is_object($mapper) ? get_class($mapper) : gettype($mapper)
            ));
        }

        return parent::setMapper($mapper);
    }

    /**
     * @return string
     */
    protected function getRegistrationToken()
    {
        return md5(uniqid(mt_rand(), true));
    }
}
