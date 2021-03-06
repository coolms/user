<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsUser\Options\ViewHelperServiceOptionsInterface,
    CmsUser\Options\ModuleOptions,
    CmsUser\View\Helper\DisplayName;

class DisplayNameHelperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return DisplayName
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();

        /* @var $options ViewHelperServiceOptionsInterface */
        $options = $services->get(ModuleOptions::class);

        return new DisplayName($options);
    }
}
