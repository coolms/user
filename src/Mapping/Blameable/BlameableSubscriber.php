<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Mapping\Blameable;

use Doctrine\Common\EventArgs,
    Doctrine\Common\NotifyPropertyChanged,
    Gedmo\Blameable\BlameableListener,
    CmsDoctrine\Mapping\Dateable\TimestampableSubscriber;

/**
 * The Blameable subscriber.
 *
 * @author  Dmitry Popov <d.popov@altgraphic.com>
 */
class BlameableSubscriber extends BlameableListener
{
    /**
     * @var bool
     */
    protected $useAssociations = true;

    /**
     * __construct
     */
    public function __construct($useAssociations = null)
    {
        if (!class_exists(TimestampableSubscriber::CHANGEABLE_ODM_ANNOTATION_ALIAS)) {
            class_alias(TimestampableSubscriber::CHANGEABLE_ANNOTATION, TimestampableSubscriber::CHANGEABLE_ODM_ANNOTATION_ALIAS);
        }

        if (!class_exists(TimestampableSubscriber::CHANGEABLE_ORM_ANNOTATION_ALIAS)) {
            class_alias(TimestampableSubscriber::CHANGEABLE_ANNOTATION, TimestampableSubscriber::CHANGEABLE_ORM_ANNOTATION_ALIAS);
        }

        parent::__construct();

        if (null !== $useAssociations) {
            $this->useAssociations = $useAssociations;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadClassMetadata(EventArgs $eventArgs)
    {
        parent::loadClassMetadata($eventArgs);

        $meta = $eventArgs->getClassMetadata();
        $name = $meta->getName();

        if ($this->useAssociations && !empty(self::$configurations[$this->name][$name]['mappings'])) {
            $this->getEventAdapter($eventArgs)
                ->remap($meta, self::$configurations[$this->name][$name]['mappings'], $this->user);
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function getNamespace()
    {
        return __NAMESPACE__;
    }

    /**
     * {@inheritDoc}
     */
    protected function updateField($object, $ea, $meta, $field)
    {
        $property = $meta->getReflectionProperty($field);
        $oldValue = $property->getValue($object);
        $newValue = $this->getUserValue($meta, $field);

        //if blame is reference, persist object
        if ($meta->hasAssociation($field)) {
            $ea->getObjectManager()->persist($newValue);
        }

        $setter = 'set' . ucfirst($field);
        if (method_exists($object, $setter)) {
            $object->$setter($newValue);
        } else {
            $property->setValue($object, $newValue);
        }

        if ($object instanceof NotifyPropertyChanged) {
            $uow = $ea->getObjectManager()->getUnitOfWork();
            $uow->propertyChanged($object, $field, $oldValue, $newValue);
        }
    }
}
