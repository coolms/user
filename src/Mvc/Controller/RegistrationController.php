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

use Zend\Form\ElementInterface,
    Zend\Mvc\Controller\AbstractActionController,
    Zend\Stdlib\Parameters,
    Zend\Stdlib\ResponseInterface,
    Zend\View\Model\ViewModel,
    CmsUser\Options\ControllerOptionsInterface,
    CmsUser\Service\UserServiceAwareTrait,
    CmsUser\Service\UserServiceInterface;

/**
 * Registration controller
 */
class RegistrationController extends AbstractActionController
{
    use UserServiceAwareTrait;

    /**
     * @var ControllerOptionsInterface
     */
    protected $options;

    /**
     * @var string
     */
    protected $registrationNamespace = 'cms-user-registration';

    /**
     * @var ElementInterface
     */
    protected $identityElement;

    /**
     * @var ElementInterface
     */
    protected $credentialElement;

    /**
     * __construct
     *
     * @param UserServiceInterface $userService
     * @param ControllerOptionsInterface $options
     * @param ElementInterface $identityElement
     * @param ElementInterface $credentialElement
     */
    public function __construct(
        UserServiceInterface $userService,
        ControllerOptionsInterface $options,
        ElementInterface $identityElement = null,
        ElementInterface $credentialElement = null
    ) {
        $this->setUserService($userService);
        $this->options = $options;
        $this->identityElement = $identityElement;
        $this->credentialElement = $credentialElement;
    }

    /**
     * Register index action
     *
     * Displays user registration form
     *
     * @return ResponseInterface|ViewModel
     */
    public function indexAction()
    {
        $authPlugin = $this->cmsAuthentication();

        // if the user is logged in, we don't need to register
        if ($authPlugin->hasIdentity()) {
            // redirect to the default user route
            $route = $this->options->getDefaultUserRoute();
            if (is_callable($route)) {
                $route = $route($authPlugin->getIdentity());
            }

            return $this->redirect()->toRoute($route);
        }

        // if registration is disabled
        if (!($enableRegistration = $this->options->getEnableRegistration())) {
            return new ViewModel(compact('enableRegistration'));
        }

        if ($this->options->getUseRegistrationRedirectParameter()) {
            $redirect = $this->params()->fromQuery('redirect', false);
        } else {
            $redirect = false;
        }

        $url = $this->url()->fromRoute(null, [],
            $redirect ? ['query' => ['redirect' => rawurldecode($redirect)]] : []
        );

        $prg = $this->prg($url, true);
        // Return early if prg plugin returned a response
        if ($prg instanceof ResponseInterface) {
            return $prg;
        }

        $post = $prg;

        $this->flashMessenger()->setNamespace($this->registrationNamespace)->clearCurrentMessages();

        $form = $this->getUserService()->getRegisterForm();
        $form->setAttribute('action', $this->url()->fromRoute());
        if ($redirect && $form->has('redirect')) {
            $form->get('redirect')->setValue($redirect);
        }

        if ($post && $form->setData($post)->isValid()) {

            $redirect = empty($post['redirect']) ? $redirect : $post['redirect'];

            $identity = $this->getUserService()->register($post);

            // Return early if an user service returned a response
            if ($identity instanceof ResponseInterface) {
                return $identity;
            } elseif ($identity) { // We are registered

                if ($this->identityElement && $this->credentialElement
                    && $this->options->getLoginAfterRegistration()
                ) {
                    // Create authentication data
                    $identityFields = $this->options->getIdentityFields();
                    if ($this->options->getEnableUsername()) {
                        $post[$this->identityElement->getName()] = $identity->getEmail();
                    } elseif (in_array('username', $identityFields)) {
                        $post[$this->identityElement->getName()] = $identity->getUsername();
                    }
                    $post[$this->credentialElement->getName()] = $post['password'];
                    if ($redirect) {
                        $post['redirect'] = $redirect;
                    }

                    $this->flashMessenger()->addSuccessMessage($this->translate(
                        'Congratulations! You have successfully registered. ' .
                        'Please, check your inbox to confirm your email address ' .
                        'and to complete registration.'
                    , 'CmsUser'));

                    $this->getRequest()->setPost(new Parameters($post));
                    return $this->forward()->dispatch(
                        $this->options->getAuthenticationController(),
                        ['action' => 'authenticate']
                    );
                }

                if ($redirect) {
                    return $this->redirect()->toUrl($redirect);
                }

                // redirect to the default user route
                $route = $this->options->getDefaultUserRoute();
                if (is_callable($route)) {
                    $route = $route($authPlugin->getIdentity());
                }

                return $this->redirect()->toRoute($route);
            }
        }

        return new ViewModel(compact('enableRegistration', 'form'));
    }
}
