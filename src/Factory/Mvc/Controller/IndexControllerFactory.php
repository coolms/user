<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\Mvc\Controller;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsUser\Mvc\Controller\IndexController,
    CmsUser\Options\ControllerOptionsInterface,
    CmsUser\Options\ModuleOptions;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        /* @var $options ControllerOptionsInterface */
        $options = $services->get(ModuleOptions::class);

        return new IndexController(
            $services->get('DomainServiceManager')->get($options->getUserEntityClass()),
            $options
        );
    }
}
