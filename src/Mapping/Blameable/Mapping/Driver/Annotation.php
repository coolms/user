<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Mapping\Blameable\Mapping\Driver;

use Gedmo\Blameable\Mapping\Driver\Annotation as BaseAnnotation,
    CmsDoctrine\Mapping\Dateable\Mapping\Driver\Annotation as TimestampableAnnotation;

class Annotation extends BaseAnnotation
{
    /**
     * changedBy property
     */
    const CHANGEDBY_PROPERTY = 'changedBy';

    /**
     * createdBy property
     */
    const CREATEDBY_PROPERTY = 'createdBy';

    /**
     * updatedBy property
     */
    const UPDATEDBY_PROPERTY = 'updatedBy';

    /**
     * {@inheritDoc}
     */
    public function readExtendedMetadata($meta, array &$config)
    {
        $class = $this->getMetaReflectionClass($meta);

        $properties = [static::CHANGEDBY_PROPERTY, static::CREATEDBY_PROPERTY, static::UPDATEDBY_PROPERTY];
        foreach ($properties as $propertyName) {
            if (!$class->hasProperty($propertyName)) {
                continue;
            }

            $property = $class->getProperty($propertyName);
            if ($meta->isMappedSuperclass && !$property->isPrivate() ||
                $meta->isInheritedField($propertyName) ||
                $meta->isInheritedAssociation($propertyName) ||
                $meta->hasField($propertyName) ||
                $meta->hasAssociation($propertyName)
            ) {
                continue;
            }

            $blameable = $this->reader->getPropertyAnnotation($property, static::BLAMEABLE);
            if (!$blameable) {
                continue;
            }

            if ($propertyName === static::CHANGEDBY_PROPERTY) {
                $changeable = $this->reader->getClassAnnotation($class, TimestampableAnnotation::CHANGEABLE);
                if (!empty($changeable->field) && !$blameable->field) {
                    $blameable->field = $changeable->field;
                }
            }

            if ($property->getDeclaringClass()->getName() === $meta->getName()) {
                $config['fields'][] = $propertyName;
                $meta->mapField([
                    'fieldName' => $propertyName,
                    'type' => 'string',
                    'length' => 255,
                    'nullable' => $propertyName === static::CREATEDBY_PROPERTY ? false : true,
                ]);
            } else {
                $meta->mapField([
                    'fieldName' => $propertyName,
                    'inherited' => $property->getDeclaringClass()->getName(),
                ]);
            }
        }

        parent::readExtendedMetadata($meta, $config);
    }
}
