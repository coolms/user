<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Initializer;

use Zend\ServiceManager\AbstractPluginManager,
    Zend\ServiceManager\InitializerInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsUser\Service\UserServiceAwareInterface;

class UserServiceInitializer implements InitializerInterface
{
    /**
     * {@inheritDoc}
     */
    public function initialize($instance, ServiceLocatorInterface $services)
    {
        if ($instance instanceof UserServiceAwareInterface) {
            if ($services instanceof AbstractPluginManager) {
                $services = $services->getServiceLocator();
            }

            /* @var $options \CmsUser\Options\UserServiceOptionsInterface */
            $options = $services->get('CmsUser\\Options\\ModuleOptions');
            $instance->setUserService($services->get('DomainServiceManager')->get($options->getClassName()));
        }
    }
}
