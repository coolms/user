<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsUser\Service\UserService;

class UserServiceFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $domainServices)
    {
        $services = $domainServices->getServiceLocator();

        /* @var $options \CmsUser\Options\UserServiceOptionsInterface */
        $options = $services->get('CmsUser\\Options\\ModuleOptions');

        /* @var $passwordGenerator \CmsCommon\Crypt\PasswordGeneratorInterface */
        $passwordGenerator = $services->get($options->getPasswordGeneratorService());

        /* @var $mailService \CmsMailer\Service\MailServiceInterface */
        $mailService = $services->get($options->getMailService());
        $mailService->setFromAddress($options->getSenderEmailAddress())
                    ->setFromName($options->getSenderName());

        return new UserService(
            $options,
            $domainServices,
            $passwordGenerator,
            $mailService
        );
    }
}
