<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\Controller;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsCommon\Form\CommonOptionsInterface,
    CmsUser\Controller\AuthenticationController;

class AuthenticationControllerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $controllers)
    {
        $services = $controllers->getServiceLocator();
        /* @var $options \CmsUser\Options\ModuleOptions */
        $options = $services->get('CmsUser\\Options\\ModuleOptions');

        if ($options instanceof CommonOptionsInterface) {
            $formOptions = $options->toArray();
        } else {
            $formOptions = [];
        }

        if (!isset($formOptions['use_reset_element'])) {
            $formOptions['use_reset_element'] = true;
        }

        return new AuthenticationController(
            $services->get('DomainServiceManager')->get($options->getClassName()),
            $options,
            $services->get('FormElementManager')->get('CmsUser\\Form\\ResetPassword', $formOptions)
        );
    }
}
