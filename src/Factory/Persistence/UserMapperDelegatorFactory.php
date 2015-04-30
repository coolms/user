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
    CmsUser\Persistence\UserMapperInterface;

class UserMapperDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * {@inheritDoc}
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

        $parentLocator = $serviceLocator->getServiceLocator();

        /* @var $options \CmsUser\Options\ModuleOptions */
        $options = $parentLocator->get('CmsUser\\Options\\ModuleOptions');

        $mapper->setIdentityFields($options->getIdentityFields());

        /* @var $passwordService \Zend\Crypt\Password\PasswordInterface */
        $passwordService = $parentLocator->get($options->getPasswordService());
        $mapper->setPasswordService($passwordService);

        return $mapper;
    }
}
