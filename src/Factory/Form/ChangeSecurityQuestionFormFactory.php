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

class ChangeSecurityQuestionFormFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $elements)
    {
        $services = $elements->getServiceLocator();
        /* @var $options \CmsUser\Options\FormOptionsInterface */
        $options = $services->get('CmsUser\\Options\\ModuleOptions');

        $creationOptions = $options->toArray();
        $creationOptions['label'] = 'Changing Security Question';

        $form = $elements->get($options->getUserEntityClass(), $creationOptions);
        $form->setName('change-security-question-form');
        $form->setElementGroup([
            'passwordVerify',
            'question',
            'answer',
        ]);

        return $form;
    }
}
