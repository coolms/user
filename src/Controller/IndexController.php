<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\Stdlib\ResponseInterface,
    Zend\View\Model\ViewModel,
    CmsUser\Options\ControllerOptionsInterface,
    CmsUser\Service\UserServiceAwareTrait,
    CmsUser\Service\UserServiceInterface;

class IndexController extends AbstractActionController
{
    use UserServiceAwareTrait;

    /**
     * @var ControllerOptionsInterface
     */
    protected $options;

    /**
     * __construct
     *
     * @param UserServiceInterface $userService
     * @param ControllerOptionsInterface $options
     */
    public function __construct(
        UserServiceInterface $userService,
        ControllerOptionsInterface $options
    ){
        $this->setUserService($userService);
        $this->options = $options;
    }

    /**
     * Index action
     *
     * The method show to users they are guests
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel;
    }

    /**
     * Edit user profile action
     *
     * Displays user profile edit form
     *
     * @return ResponseInterface|ViewModel
     */
    public function editProfileAction()
    {
        // if the user is not logged in, we can't edit profile
        if (!$this->cmsAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute($this->options->getLoginRedirectRoute());
        }

        $url = $this->url()->fromRoute(null, ['action' => 'edit-profile']);

        $prg = $this->prg($url, true);
        if ($prg instanceof ResponseInterface) {
            return $prg;
        }

        $post = $prg;

        $form = $this->getUserService()->getEditProfileForm();
        $identity = $this->cmsAuthentication()->getIdentity();
        $form->bind($identity);
        $form->setAttribute('action', $url);

        if ($post && $form->setData($post)->isValid()) {

            $result = $this->getUserService()->editProfile($identity);

            // Return early if an user service returned a response
            if ($result instanceof ResponseInterface) {
                return $result;
            } elseif ($result) {
                $fm = $this->flashMessenger();
                $fm->setNamespace($form->getName() . '-' . $fm::NAMESPACE_SUCCESS)
                   ->addMessage($this->translate('Data has been successfully saved'));
            }
        }

        return new ViewModel(compact('form'));
    }

    /**
     * Change password action
     *
     * Displays user change password form
     *
     * @return ResponseInterface|ViewModel
     */
    public function changePasswordAction()
    {
        // if the user is not logged in, we can't change password
        if (!$this->cmsAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute($this->options->getLoginRedirectRoute());
        }

        $url = $this->url()->fromRoute(null, ['action' => 'change-password']);

        $prg = $this->prg($url, true);
        if ($prg instanceof ResponseInterface) {
            return $prg;
        }

        $post = $prg;

        $form = $this->getUserService()->getChangePasswordForm();
        $form->setObject($this->cmsAuthentication()->getIdentity());
        $form->setAttribute('action', $url);

        if ($post && $form->setData($post)->isValid()) {

            $identity = $this->getUserService()->changePassword($post);

            // Return early if an user service returned a response
            if ($identity instanceof ResponseInterface) {
                return $identity;
            } elseif ($identity) { // Password changed successfully
                $viewModel = new ViewModel(compact('identity'));
                $viewModel->setTemplate('cms-user/index/change-password-success');

                return $viewModel;
            }
        }

        return new ViewModel(compact('form'));
    }

    /**
     * Change email action
     *
     * Displays change user email form.
     *
     * @return ResponseInterface|ViewModel
     */
    public function changeEmailAction()
    {
        // if the user is not logged in, we can't change email
        if (!$this->cmsAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute($this->options->getLoginRedirectRoute());
        }

        $url = $this->url()->fromRoute(null, ['action' => 'change-email']);
        $prg = $this->prg($url, true);
        if ($prg instanceof ResponseInterface) {
            return $prg;
        }

        $post = $prg;

        $form = $this->getUserService()->getChangeEmailForm();
        $form->setObject($this->cmsAuthentication()->getIdentity());
        $form->setAttribute('action', $url);

        if ($post && $form->setData($post)->isValid()) {

            $identity = $this->getUserService()->changeEmail($post);

            // Return early if an user service returned a response
            if ($identity instanceof ResponseInterface) {
                return $identity;
            } elseif ($identity) { // Email changed successfully
                $viewModel = new ViewModel(compact('identity'));
                $viewModel->setTemplate('cms-user/index/change-email-success');

                return $viewModel;
            }
        }

        return new ViewModel(compact('form'));
    }

    /**
     * User email confirm action
     *
     * @return ResponseInterface|ViewModel
     */
    public function confirmEmailAction()
    {
        $token = $this->params()->fromRoute('token');
        if ($token) {
            $identity = $this->getUserService()->confirmEmail($token);
            if ($identity instanceof ResponseInterface) {
                return $identity;
            } elseif ($identity) {
                $viewModel = new ViewModel(compact('identity'));
                $viewModel->setTemplate('cms-user/index/confirm-email');

                return $viewModel;
            }
        }

        return $this->redirect()->toRoute($this->options->getDefaultUserRoute());
    }

    /**
     * Change security question action
     *
     * @return ResponseInterface|ViewModel
     */
    public function changeSecurityQuestionAction()
    {
        // if the user is not logged in, we can't change security question
        if (!$this->cmsAuthentication()->hasIdentity()) {
            // redirect to the login redirect route
            return $this->redirect()->toRoute($this->options->getLoginRedirectRoute());
        }

        $url = $this->url()->fromRoute(null, ['action' => 'change-security-question']);
        $prg = $this->prg($url, true);
        if ($prg instanceof ResponseInterface) {
            return $prg;
        }

        $post = $prg;

        $form = $this->getUserService()->getChangeSecurityQuestionForm();
        $form->setObject($this->cmsAuthentication()->getIdentity());
        $form->setAttribute('action', $url);

        if ($post) {

            $identity = $this->getUserService()->changeSecurityQuestion($post);

            // Return early if an user service returned a response
            if ($identity instanceof ResponseInterface) {
                return $identity;
            } elseif ($identity) { // Security question changed successfully
                $viewModel = new ViewModel(compact('identity'));
                $viewModel->setTemplate('cms-user/index/change-security-question-success');

                return $viewModel;
            }
        }

        return new ViewModel(compact('form'));
    }
}
