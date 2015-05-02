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
    Zend\Validator\Callback;

class NoUsernameExistsValidatorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $validators)
    {
        $services = $validators->getServiceLocator();
        /* @var $options \CmsUser\Options\InputFilterOptionsInterface */
        $options = $services->get('CmsUser\\Options\\ModuleOptions');
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

        return $validators->get('Callback', [
            'messages' => [
                Callback::INVALID_VALUE => 'This username is already taken',
            ],
            'callback' => function ($value) use ($userMapper, $identity)
            {
                if ($identity) {
                    $filter = new StringToLower(['encoding' => 'UTF-8']);
                    if ($filter->filter($identity->getUsername()) === $filter->filter($value)) {
                        return true;
                    }
                }

                return !$userMapper->findOneByUsername($value);
            },
            'break_chain_on_failure' => true,
        ]);
    }
}
