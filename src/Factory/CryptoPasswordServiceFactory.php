<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Crypt\Password\Bcrypt,
    CmsUser\Options\PasswordOptionsInterface,
    CmsUser\Options\ModuleOptions;

class CryptoPasswordServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return Bcrypt
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options PasswordOptionsInterface */
        $options = $serviceLocator->get(ModuleOptions::class);
        return new Bcrypt(['cost' => $options->getPasswordCost()]);
    }
}
