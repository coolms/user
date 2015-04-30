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
    Zend\Mvc\MvcEvent,
    CmsUser\Mapping\Blameable\BlameableSubscriber;

/**
 * Blameable event listener
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class BlameableListener extends AbstractListenerAggregate
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
        $sm = $e->getApplication()->getServiceManager();
        if (!$sm->has('CmsDoctrine\\ObjectManager')) {
            return;
        }

        $blameable = new BlameableSubscriber();

        if ($sm->has('Zend\\Authentication\\AuthenticationServiceInterface')) {
            $identity = $sm->get('Zend\\Authentication\\AuthenticationServiceInterface')->getIdentity();
        	$blameable->setUserValue($identity);
        }

        $sm->get('CmsDoctrine\\ObjectManager')
            ->getEventManager()
            ->addEventSubscriber($blameable);
    }
}
