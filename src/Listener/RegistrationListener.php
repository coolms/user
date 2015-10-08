<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Listener;

use Zend\EventManager\AbstractListenerAggregate,
    Zend\EventManager\EventManagerInterface,
    Zend\Http\Request as HttpRequest,
    Zend\Mvc\MvcEvent,
    CmsAuthorization\Mapping\RoleableInterface,
    CmsAuthorization\Options\ModuleOptions as AuthorizationModuleOptions,
    CmsPermissions\Options\ModuleOptions as PermissionsModuleOptions,
    CmsUser\Service\UserService;

/**
 * User register event listener
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class RegistrationListener extends AbstractListenerAggregate
{
    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
    	$this->listeners[] = $events->attach(MvcEvent::EVENT_BOOTSTRAP, [$this, 'onBootstrap'], -100);
    }

    /**
     * Event callback to be triggered on bootstrap
     *
     * @param MvcEvent $e
     * @return void
     */
    public function onBootstrap(MvcEvent $e)
    {
        if (!$e->getRequest() instanceof HttpRequest) {
            return;
        }

        $app = $e->getApplication();
        $services = $app->getServiceManager();

        $eventManager       = $app->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();

        $sharedEventManager->attach(UserService::class, 'register', function($e) use ($services)
        {
            $user = $e->getParam('user');
            if ($user instanceof RoleableInterface &&
                $services->has(AuthorizationModuleOptions::class)
            ) {
                /* @var $config PermissionsModuleOptions */
                $config = $services->get(PermissionsModuleOptions::class);
                $roleClass = $config->getRoleEntityClass();
                $mapper = $services->get('MapperManager')->get($roleClass);
                if ($defaultRole = $mapper->find($config->getAuthenticatedRole())) {
                    $user->addRole($defaultRole);
                }
            }
        }, 100);
    }
}
