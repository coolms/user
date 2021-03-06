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
    Zend\Validator\Regex,
    Zend\Validator\StringLength,
    Zend\Validator\ValidatorChain,
    Zend\Validator\ValidatorInterface,
    CmsUser\Options\InputFilterOptionsInterface,
    CmsUser\Options\ModuleOptions;

class UsernameValidatorFactory implements FactoryInterface
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
                StringLength::TOO_SHORT => 'The username must be at least %min% characters long',
                StringLength::TOO_LONG => 'The username must not be more than %max% characters',
            ],
            'encoding' => 'UTF-8',
            'min' => 5,
            'max' => 30,
        ], true);

        $validator->attachByName('Regex', [
            'messages' => [
                Regex::NOT_MATCH => 'Incorrect username. ' .
                    'Username must contain alphanumeric characters without spaces',
            ],
            'pattern' => $options->getUsernameRegexPattern(),
        ], true);

        $validator->attachByName('CmsUserNoUsernameExists', [], true);

        return $validator;
    }
}
