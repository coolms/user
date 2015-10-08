<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\Validator;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Validator\Callback,
    Zend\Validator\ValidatorChain,
    CmsUser\Options\ModuleOptions;

class AnswerVerifyValidatorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $validators)
    {
        $services = $validators->getServiceLocator();
        /* @var $options ModuleOptions */
        $options = $services->get(ModuleOptions::class);

        $identity = null;
        if ($services->has($options->getAuthenticationService())) {
            /* @var $authService \Zend\Authentication\AuthenticationServiceInterface */
            $authService = $services->get($options->getAuthenticationService());

            if ($authService->hasIdentity()) {
                /* @var $identity \CmsUser\Mapping\UserInterface */
                $identity = $authService->getIdentity();
            }
        }

        $validatorChain = new ValidatorChain();

        $validatorChain->attachByName('Callback', [
            'messages' => [
                Callback::INVALID_VALUE => 'Your answer is wrong. '
                    . 'Please provide the correct answer',
            ],
            'callback' => function($value, $context = []) use ($identity)
            {
                if (isset($context['answer'])) {
                    return strtolower($context['answer']) === $value;
                } elseif ($identity) {
                    return $identity->getAnswer() === $value;
                }
                return false;
            },
        ], true);

        return $validatorChain;
    }
}
