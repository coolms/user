<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\Validator;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Validator\StringLength,
    Zend\Validator\ValidatorChain,
    Zend\Validator\ValidatorInterface,
    CmsUser\Options\InputFilterOptionsInterface,
    CmsUser\Options\ModuleOptions;

class EmailAddressValidatorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ValidatorInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        /* @var $options InputFilterOptionsInterface */
        $options = $services->get(ModuleOptions::class);

        $validator = new ValidatorChain();
        $validator->setPluginManager($serviceLocator);

        $validator->attachByName('StringLength', [
            'messages' => [
                StringLength::TOO_SHORT => 'Email address must be at least %min% characters long',
                StringLength::TOO_LONG => 'Email address must not be more than %max% characters',
            ],
            'encoding' => 'UTF-8',
            'min' => 6,
            'max' => 60,
        ], true);

        $validator->attachByName('EmailAddress', [], true);
        $validator->attachByName('CmsUserNoEmailExists', [], true);

        return $validator;
    }
}
