<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Mvc\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\Stdlib\ResponseInterface,
    Zend\View\Model\ViewModel,
    CmsCommon\Stdlib\OptionsProviderTrait,
    CmsUser\Options\ControllerOptionsInterface,
    CmsUser\Service\UserServiceAwareTrait,
    CmsUser\Service\UserServiceInterface;

/**
 * AuthenticationController
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 *
 * @method IndexController setOptions(\CmsUser\Options\ControllerOptionsInterface $options)
 * @method \CmsUser\Options\ControllerOptionsInterface getOptions()
 * @method \CmsAuthentication\Mvc\Controller\Plugin\Authentication cmsAuthentication()
 */
class AuthenticationController extends AbstractActionController
{
    use UserServiceAwareTrait,
        OptionsProviderTrait;

    /**
     * __construct
     *
     * @param UserServiceInterface $userService
     * @param ControllerOptionsInterface $options
     * @param FormInterface $form
     */
    public function __construct(
        UserServiceInterface $userService,
        ControllerOptionsInterface $options
    ) {
        $this->setUserService($userService);
        $this->setOptions($options);
    }

    /**
     * Reset password action
     *
     * Displays user reset password form and sends email with reset link to user
     *
     * @return array|ResponseInterface|ViewModel
     */
    public function resetPasswordAction()
    {
        // if the user is logged in, we can't reset password
        if ($this->cmsAuthentication()->hasIdentity()) {
            // redirect to the defualt user route
            return $this->redirect()->toRoute($this->getOptions()->getDefaultUserRoute());
        }

        if ($token = $this->params()->fromRoute('token')) {
            $identity = $this->getUserService()->confirmPasswordReset($token);
            if ($identity instanceof ResponseInterface) {
            	return $identity;
            } elseif ($identity) {
                $viewModel = new ViewModel(compact('identity'));
                $viewModel->setTemplate('cms-user/authentication/reset-password-success');
            	return $viewModel;
            }

            return $this->redirect()->toRoute();
        }

        $url = $this->url()->fromRoute();
        $prg = $this->prg($url, true);
        if ($prg instanceof ResponseInterface) {
            return $prg;
        }

        $post = $prg;
        $form = $this->getUserService()->getResetPasswordForm();
        $form->setAttribute('action', $url);

        if ($post && $form->setData($post)->isValid()) {

            $identity = $this->getUserService()->resetPassword($form->get('identity')->getValue());

            // Return early if an user service returned a response
            if ($identity instanceof ResponseInterface) {
                return $identity;
            } elseif ($identity) { // Password reset successfully
                $viewModel = new ViewModel(compact('identity'));
                $viewModel->setTemplate('cms-user/authentication/reset-password-warning');
                return $viewModel;
            }
        }

        return new ViewModel(compact('form'));
    }
}
