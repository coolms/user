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
    Zend\Validator\Callback,
    Zend\Validator\ValidatorChain,
    Zend\Validator\ValidatorInterface,
    CmsUser\Options\InputFilterOptionsInterface,
    CmsUser\Options\ModuleOptions;

class BirthdayVerifyValidatorFactory implements FactoryInterface
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

        /* @var $userMapper \CmsUser\Persistence\UserMapperInterface */
        $userMapper = $services->get('MapperManager')->get($options->getUserEntityClass());
        $identityField = $services->get('FormElementManager')->get('CmsAuthenticationIdentity')->getName();

        $validatorChain = new ValidatorChain();
        $validatorChain->attachByName('Callback', [
            'messages' => [
                Callback::INVALID_VALUE => 'Your birthday is wrong. '
                    . 'Please provide the correct birthday',
            ],
            'callback' => function($value, $context = []) use ($userMapper, $identityField) {
                if (!empty($context[$identityField])) {
                    if ($identity = $userMapper->findByIdentity($context[$identityField])) {
                        return (new \DateTime($value)) == $identity->getBirthday();
                    }
                }
                return true;
            },
        ], true);

        return $validatorChain;
    }
}
