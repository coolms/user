<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Form;

use CmsCommon\Form\Form,
    Zend\Form\ElementInterface;

class ResetPassword extends Form
{
    /**
     * @var ElementInterface
     */
    protected $identityElement;

    /**
     * __construct
     *
     * @property string $name
     * @property array $options
     */
    public function __construct($name = null, $options = [])
    {
        parent::__construct($name ?: 'reset-password', $options);

        // Setting some defaults
        if (null === $this->getLabel()) {
            $this->setLabel('Resetting Password');
        }
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();

        $this->identityElement = $this->getFormFactory()->getFormElementManager()->get('CmsAuthenticationIdentity');

        $this->add(
            $this->identityElement,
            ['priority' => 20]
        );

        $this->add(
            ['type'  => 'CmsUserBirthdayVerify'],
            ['priority' => 10]
        );

        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this);
    }

    /**
     * {@inheritDoc}
     */
    public function has($elementOrFieldset)
    {
        if (parent::has($elementOrFieldset)) {
            return true;
        }

        if ($elementOrFieldset === 'identity' && $this->identityElement) {
            $elementOrFieldset = $this->identityElement->getName();
        } else {
            return false;
        }

        return parent::has($elementOrFieldset);
    }

    /**
     * {@inheritDoc}
     */
    public function get($elementOrFieldset)
    {
        if (!parent::has($elementOrFieldset)
            && $elementOrFieldset === 'identity'
            && $this->identityElement
        ) {
            $elementOrFieldset = $this->identityElement->getName();
        }

        return parent::get($elementOrFieldset);
    }

    /**
     * {@inheritDoc}
     */
    public function remove($elementOrFieldset)
    {
        if (!parent::has($elementOrFieldset)
            && $elementOrFieldset === 'identity'
            && $this->identityElement
        ) {
            $elementOrFieldset = $this->identityElement->getName();
        }

        return parent::remove($elementOrFieldset);
    }
}
