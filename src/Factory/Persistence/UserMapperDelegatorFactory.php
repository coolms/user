<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\Persistence;

use Zend\ServiceManager\DelegatorFactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsCommon\Persistence\MapperInterface,
    CmsUser\Options\ModuleOptions,
    CmsUser\Persistence\UserMapperInterface;

class UserMapperDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return MapperInterface
     */
    public function createDelegatorWithName(
        ServiceLocatorInterface $serviceLocator,
        $name,
        $requestedName,
        $callback
    ) {
        $mapper = $callback();

        if (!$mapper instanceof UserMapperInterface) {
            return $mapper;
        }

        $services = $serviceLocator->getServiceLocator();

        /* @var $options ModuleOptions */
        $options = $services->get(ModuleOptions::class);

        $mapper->setIdentityFields($options->getIdentityFields());

        /* @var $passwordService \Zend\Crypt\Password\PasswordInterface */
        $passwordService = $services->get($options->getPasswordService());
        $mapper->setPasswordService($passwordService);

        return $mapper;
    }
}
