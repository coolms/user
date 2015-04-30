<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Form\Element;

use Zend\Form\Element\Text,
    Zend\InputFilter\InputProviderInterface;

class MobilePhoneNumber extends Text implements InputProviderInterface
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'text',
        'name' => 'mobilePhoneNumber'
    ];

    /**
     * @var string
     */
    protected $label = 'Mobile phone number';

    /**
     * {@inheritDoc}
     */
    public function getInputSpecification()
    {
        return [
            'allow_empty' => true,
            'filters' => [
                ['name' => 'StripTags'],
                ['name' => 'StringTrim'],
                ['name' => 'Null'],
            ],
            'validators' => [
                [
                    'name' => 'PhoneNumber',
                    'options' => [
                        'country' => 'BY',
                        'allowed_types' => ['mobile'],
                    ],
                ],
            ],
        ];
    }
}
