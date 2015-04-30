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
    Zend\ServiceManager\ServiceLocatorInterface;

class ChangeEmailFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $elements)
    {
        $services = $elements->getServiceLocator();
        /* @var $options \CmsUser\Options\ModuleOptions */
        $options = $services->get('CmsUser\\Options\\ModuleOptions');

        $creationOptions = $options->toArray();
        $creationOptions['label'] = 'Changing Email Address';

        /* @var $form \CmsCommon\Form\Form */
        $form = $elements->get($options->getClassName(), $creationOptions);
        $form->setName('change-email-form');
        $form->setElementGroup([
            'question',
            'answerVerify',
            'email',
        ]);
        $form->get('email')->setLabel('New Email');

        return $form;
    }
}