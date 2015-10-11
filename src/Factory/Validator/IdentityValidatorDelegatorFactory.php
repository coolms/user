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

use Zend\I18n\Validator\Alnum,
    Zend\ServiceManager\DelegatorFactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Zend\Validator\Callback,
    Zend\Validator\ValidatorChain,
    Zend\Validator\ValidatorInterface,
    CmsUser\Options\InputFilterOptionsInterface,
    CmsUser\Options\ModuleOptions;

class IdentityValidatorDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return ValidatorInterface
     */
    public function createDelegatorWithName(
        ServiceLocatorInterface $validators,
        $name,
        $requestedName,
        $callback
    ) {
        $identityValidator = $callback();

        if (!$identityValidator instanceof ValidatorChain
            || $requestedName !== 'CmsAuthenticationIdentity'
        ) {
            return $identityValidator;
        }

        $services = $validators->getServiceLocator();

        /* @var $options InputFilterOptionsInterface */
        $options = $services->get(ModuleOptions::class);

        $identityFields = $options->getIdentityFields();
        if ($identityFields == ['email']) {
            $identityValidator->prependByName('EmailAddress', [], true);
        } elseif ($identityFields == ['username']) {
            $identityValidator->prependByName('Alnum', [
                'messages' => [
                    Alnum::NOT_ALNUM => 'Incorrect identity. ' .
                    'Identity must contain alphanumeric characters without spaces',
                ],
                'allowWhiteSpace' => false,
            ], true);
        }

        /* @var $userMapper \CmsUser\Persistence\UserMapperInterface */
        $userMapper = $services->get('MapperManager')->get($options->getUserEntityClass());

        $identityValidator->attachByName('Callback', [
            'messages' => [
                Callback::INVALID_VALUE => 'A record with the supplied identity could not be found',
            ],
            'callback' => function($value) use ($userMapper) {
                return (bool) $userMapper->findByIdentity($value);
            },
        ], true);

        return $identityValidator;
    }
}
