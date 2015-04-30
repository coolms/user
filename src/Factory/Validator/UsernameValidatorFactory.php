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
    Zend\Validator\ValidatorChain;

class UsernameValidatorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $validators)
    {
        $services = $validators->getServiceLocator();
        /* @var $options \CmsUser\Options\InputFilterOptionsInterface */
        $options = $services->get('CmsUser\\Options\\ModuleOptions');

        $validator = new ValidatorChain();
        $validator->setPluginManager($validators);

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
