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
    Zend\Validator\GreaterThan,
    Zend\Validator\LessThan,
    Zend\Validator\ValidatorChain;

class BirthdayValidatorFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $validatorChain = new ValidatorChain();

        $intl = new \IntlDateFormatter(
            \Locale::getDefault(),
            \IntlDateFormatter::LONG,
            \IntlDateFormatter::NONE
        );

        $date = (new \DateTime('now'))->modify('-100 years');
        $validatorChain->attachByName('GreaterThan', [
            'messages' => [
                GreaterThan::NOT_GREATER_INCLUSIVE => 'The date of birth '
                    . 'must be not earlier than %min% inclusive',
            ],
            'messageVariables' => [
                'min' => ['abstractOptions' => 'fmt'],
            ],
            'min' => $date->format('Y-m-d'),
            'fmt' => $intl->format($date),
            'inclusive' => true,
        ], true);

        $date = (new \DateTime('now'))->modify('-18 years');
        $validatorChain->attachByName('LessThan', [
            'messages' => [
                LessThan::NOT_LESS_INCLUSIVE => 'The date of birth '
                    . 'must be not later than %max% inclusive',
            ],
            'messageVariables' => [
                'max' => ['abstractOptions' => 'fmt'],
            ],
            'max' => $date->format('Y-m-d'),
            'fmt' => $intl->format($date),
            'inclusive' => true,
        ], true);

        return $validatorChain;
    }
}
