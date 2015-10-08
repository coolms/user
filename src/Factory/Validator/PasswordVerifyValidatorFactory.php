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
    CmsCommon\Mapping\Common\PasswordableInterface,
    CmsUser\Options\InputFilterOptionsInterface,
    CmsUser\Options\ModuleOptions;

class PasswordVerifyValidatorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $validators)
    {
        $services = $validators->getServiceLocator();

        /* @var $options InputFilterOptionsInterface */
        $options = $services->get(ModuleOptions::class);

        $userMapper = null;
        $identity   = null;

        if ($services->has($options->getAuthenticationService())) {
            /* @var $authService \Zend\Authentication\AuthenticationServiceInterface */
            $authService = $services->get($options->getAuthenticationService());

            if ($authService->hasIdentity()) {
                /* @var $userMapper \CmsUser\Persistence\UserMapperInterface */
                $userMapper = $services->get('MapperManager')->get($options->getUserEntityClass());
                /* @var $identity \CmsUser\Mapping\UserInterface */
                $identity = $authService->getIdentity();
            }
        }

        $validatorChain = new ValidatorChain();

        $validatorChain->attachByName('Callback', [
            'messages' => [
                Callback::INVALID_VALUE => 'Incorrect password verification',
            ],
            'callback' => function($value, $context = []) use ($userMapper, $identity) {
                if (isset($context['password'])) {
                    return $value === $context['password'];
                } elseif ($userMapper && $identity && $identity instanceof PasswordableInterface) {
                    return $userMapper->getPasswordService()->verify($value, $identity->getPassword());
                }
                return false;
            },
        ], true);

        return $validatorChain;
    }
}
