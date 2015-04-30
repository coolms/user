<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\View\Helper;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsUser\View\Helper\Username;

class UsernameHelperFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $helpers)
    {
        $services = $helpers->getServiceLocator();

        /* @var $options \CmsUser\Options\ViewHelperModuleOptionsInterface */
        $options = $services->get('CmsUser\\Options\\ModuleOptions');

        return new Username($options);
    }
}