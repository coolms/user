<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\Form\Element;

use Zend\Form\ElementInterface,
    Zend\ServiceManager\DelegatorFactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAuthentication\Form\Element\Identity,
    CmsUser\Options\AuthenticationOptionsInterface,
    CmsUser\Options\ModuleOptions;

class IdentityElementDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ElementInterface
     */
    public function createDelegatorWithName(
        ServiceLocatorInterface $serviceLocator,
        $name,
        $requestedName,
        $callback
    ) {
        $identityElement = $callback();

        if (!$identityElement instanceof Identity) {
            return $identityElement;
        }

        $services = $serviceLocator->getServiceLocator();

        /* @var $options AuthenticationOptionsInterface */
        $options = $services->get(ModuleOptions::class);

        if ($fields = $options->getIdentityFields()) {
            $last = ucfirst(array_pop($fields));
            if (count($fields) > 0) {
                $fields = array_map('ucfirst', $fields);

                $fields = (array) implode(', ', $fields);
                $fields[] = $last;

                $label = implode(' or ', $fields);
            } else {
                $label = $last;
            }

            $identityElement->setLabel($label);
            $identityElement->setOption('text_domain', 'CmsUser');
        }

        return $identityElement;
    }
}
