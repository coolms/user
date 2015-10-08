<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\Authentication;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsUser\Authentication\Storage\DefaultStorage,
    CmsUser\Options\AuthenticationOptionsInterface,
    CmsUser\Options\ModuleOptions;

class StorageFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $options AuthenticationOptionsInterface */
        $options = $serviceLocator->get(ModuleOptions::class);

        return new DefaultStorage($serviceLocator->get('MapperManager')->get($options->getUserEntityClass()));
    }
}
