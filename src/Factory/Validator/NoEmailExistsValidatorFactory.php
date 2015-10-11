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

use Zend\Filter\StringToLower,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Validator\Callback,
    Zend\Validator\ValidatorInterface,
    CmsUser\Options\InputFilterOptionsInterface,
    CmsUser\Options\ModuleOptions;

class NoEmailExistsValidatorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ValidatorInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        /* @var $options InputFilterOptionsInterface */
        $options = $services->get(ModuleOptions::class);
        /* @var $userMapper \CmsUser\Persistence\UserMapperInterface */
        $userMapper = $services->get('MapperManager')->get($options->getUserEntityClass());

        $identity = null;
        if ($services->has($options->getAuthenticationService())) {
            /* @var $authService \Zend\Authentication\AuthenticationServiceInterface */
            $authService = $services->get($options->getAuthenticationService());
        
            if ($authService->hasIdentity()) {
                /* @var $identity \CmsUser\Mapping\UserInterface */
                $identity = $authService->getIdentity();
            }
        }

        return $serviceLocator->get('Callback', [
            'messages' => [
                Callback::INVALID_VALUE => 'An user with this email already exists',
            ],
            'callback' => function ($value) use ($userMapper, $identity)
            {
                if ($identity) {
                    $filter = new StringToLower(['encoding' => 'UTF-8']);
                    if ($filter->filter($identity->getEmail()) === $filter->filter($value)) {
                        return true;
                    }
                }

                return !$userMapper->findOneByEmail($value);
            },
            'break_chain_on_failure' => true,
        ]);
    }
}
