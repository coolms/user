<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\Form;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsUser\Form\ResetPassword,
    CmsUser\Options\ModuleOptions;

class ResetPasswordFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $elements)
    {
        $services = $elements->getServiceLocator();
        /* @var $options ModuleOptions */
        $options = $services->get(ModuleOptions::class);

        $creationOptions = $options->toArray();

        // Use submit button by default
        if (!isset($creationOptions['use_submit_element'])) {
            $creationOptions['use_submit_element'] = true;
        }

        // Use reset button by default
        if (!isset($creationOptions['use_reset_element'])) {
            $creationOptions['use_reset_element'] = true;
        }

        return new ResetPassword('reset-password-form', $creationOptions);
    }
}
