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

use Zend\ServiceManager\DelegatorFactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsAuthentication\Form\Element\Identity;

class IdentityElementDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createDelegatorWithName(
        ServiceLocatorInterface $elements,
        $name,
        $requestedName,
        $callback
    ) {
        $identityElement = $callback();

        if (!$identityElement instanceof Identity) {
            return $identityElement;
        }

        $services = $elements->getServiceLocator();

        /* @var $options \CmsUser\Options\AuthenticationOptionsInterface */
        $options = $services->get('CmsUser\\Options\\ModuleOptions');

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
