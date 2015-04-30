<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Event;

use Zend\EventManager\AbstractListenerAggregate,
    Zend\EventManager\EventManagerInterface,
    Zend\Mvc\MvcEvent;

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
        $app = $e->getApplication();
        $sm  = $app->getServiceManager();

        if (!$sm->has('CmsDoctrine\\ObjectManager')) {
            return;
        }

        $eventManager       = $app->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();

        $sharedEventManager->attach('CmsUser\Service\UserService', 'register', function($e) use ($sm)
        {
            $user = $e->getParam('user');
            if ($user instanceof \CmsAuthorization\Mapping\RoleableInterface
                && $sm->has('CmsAuthorization\\Options\\ModuleOptions')
            ) {
                /* @var $config \CmsAuthorization\Options\ModuleOptions */
                $config = $sm->get('CmsAuthorization\\Options\\ModuleOptions');
                $roleClass = $config->getRoleClass();
                /* @var $objectManager \Doctrine\Common\Persistence\ObjectManager */
                $objectManager = $sm->get('CmsDoctrine\\ObjectManager');
                if ($defaultRole = $objectManager->find($roleClass, $config->getAuthenticatedRole())) {
                    $user->addRole($defaultRole);
                }
            }
        }, 100);
    }
}
