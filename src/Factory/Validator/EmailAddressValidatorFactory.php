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
    Zend\Validator\ValidatorChain;

class EmailAddressValidatorFactory implements FactoryInterface
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
