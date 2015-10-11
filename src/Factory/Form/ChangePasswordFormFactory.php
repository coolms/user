<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\Form;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsCommon\Form\FormInterface,
    CmsUser\Options\FormOptionsInterface,
    CmsUser\Options\ModuleOptions;

class ChangePasswordFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @return FormInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();
        /* @var $options FormOptionsInterface */
        $options = $services->get(ModuleOptions::class);

        $creationOptions = $options->toArray();
        $creationOptions['label'] = 'Changing Password';

        /* @var $form FormInterface */
        $form = $serviceLocator->get($options->getUserEntityClass(), $creationOptions);
        $form->setName('change-password-form');
        $form->setElementGroup([
            'password',
            'passwordVerify',
            'question',
            'answerVerify',
        ])->setValidationGroup([
            'password',
            'passwordVerify',
            'answerVerify',
        ]);

        return $form;
    }
}
