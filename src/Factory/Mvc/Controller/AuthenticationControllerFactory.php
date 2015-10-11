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
    CmsCommon\Form\CommonOptionsInterface as FormCommonOptionsInterface,
    CmsUser\Form\ResetPassword,
    CmsUser\Mvc\Controller\AuthenticationController,
    CmsUser\Options\ControllerOptionsInterface,
    CmsUser\Options\ModuleOptions;

class AuthenticationControllerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return AuthenticationController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        /* @var $options ControllerOptionsInterface */
        $options = $services->get(ModuleOptions::class);

        if ($options instanceof FormCommonOptionsInterface) {
            $formOptions = $options->toArray();
        } else {
            $formOptions = [];
        }

        if (!isset($formOptions['use_reset_element'])) {
            $formOptions['use_reset_element'] = true;
        }

        return new AuthenticationController(
            $services->get('DomainServiceManager')->get($options->getUserEntityClass()),
            $options,
            $services->get('FormElementManager')->get(ResetPassword::class, $formOptions)
        );
    }
}
