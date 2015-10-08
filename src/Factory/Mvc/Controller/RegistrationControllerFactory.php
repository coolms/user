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
    CmsUser\Mvc\Controller\RegistrationController,
    CmsUser\Options\ControllerOptionsInterface,
    CmsUser\Options\ModuleOptions;

class RegistrationControllerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $controllers)
    {
        $services = $controllers->getServiceLocator();
        /* @var $options ControllerOptionsInterface */
        $options = $services->get(ModuleOptions::class);
        /* @var $formElementManager \Zend\Form\FormElementManager */
        $formElementManager = $services->get('FormElementManager');

        return new RegistrationController(
            $services->get('DomainServiceManager')->get($options->getUserEntityClass()),
            $options,
            $formElementManager->has('CmsAuthenticationIdentity')
                ? $formElementManager->get('CmsAuthenticationIdentity')
                : null,
            $formElementManager->has('CmsAuthenticationCredential')
                ? $formElementManager->get('CmsAuthenticationCredential')
                : null
        );
    }
}
