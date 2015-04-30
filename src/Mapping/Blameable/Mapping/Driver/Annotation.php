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

        if ($class->hasProperty(static::CHANGEDBY_PROPERTY)) {
            $property = $class->getProperty(static::CHANGEDBY_PROPERTY);
            $changeable = $this->reader->getClassAnnotation($class, TimestampableAnnotation::CHANGEABLE);
            $blameable = $this->reader->getPropertyAnnotation($property, static::BLAMEABLE);

            if ($blameable) {
                if ($meta->isMappedSuperclass && !$property->isPrivate() ||
                    $meta->isInheritedField($property->name) ||
                    isset($meta->associationMappings[$property->name]['inherited'])
                ) {
                    if (!empty($changeable->field)) {
                        $config['change'][] = [
                            'field' => $property->name,
                            'trackedField' => $changeable->field,
                            'value' => $changeable->value,
                        ];
                    }
                } else {
                    if (!$meta->hasField(static::CHANGEDBY_PROPERTY)
                        && !$meta->hasAssociation(static::CHANGEDBY_PROPERTY)
                    ) {
                        $config['mappings'][static::CHANGEDBY_PROPERTY] = [
                            'fieldName' => $property->name,
                            'type' => 'string',
                            'length' => 255,
                            'nullable' => true,
                        ];
                        $meta->mapField($config['mappings'][static::CHANGEDBY_PROPERTY]);
                    }

                    if (!empty($changeable->field) && !$blameable->field) {
                        $blameable->field = $changeable->field;
                    }
                }
            }
        }

        if ($class->hasProperty(static::CREATEDBY_PROPERTY)) {
            $property = $class->getProperty(static::CREATEDBY_PROPERTY);
            if (!($meta->isMappedSuperclass && !$property->isPrivate())
                && !$meta->isInheritedField($property->name)
                && !isset($meta->associationMappings[$property->name]['inherited'])
                && !$meta->hasField(static::CREATEDBY_PROPERTY)
                && !$meta->hasAssociation(static::CREATEDBY_PROPERTY)
                && $this->reader->getPropertyAnnotation($property, static::BLAMEABLE)
            ) {
                $config['mappings'][static::CREATEDBY_PROPERTY] = [
                    'fieldName' => $property->name,
                    'type' => 'string',
                    'length' => 255,
                    'nullable' => false,
                ];
                $meta->mapField($config['mappings'][static::CREATEDBY_PROPERTY]);
            }
        }

        if ($class->hasProperty(static::UPDATEDBY_PROPERTY)) {
            $property = $class->getProperty(static::UPDATEDBY_PROPERTY);
            if (!($meta->isMappedSuperclass && !$property->isPrivate())
                && !$meta->isInheritedField($property->name)
                && !isset($meta->associationMappings[$property->name]['inherited'])
                && !$meta->hasField(static::UPDATEDBY_PROPERTY)
                && !$meta->hasAssociation(static::UPDATEDBY_PROPERTY)
                && $this->reader->getPropertyAnnotation($property, static::BLAMEABLE)
            ) {
                $config['mappings'][static::UPDATEDBY_PROPERTY] = [
                    'fieldName' => $property->name,
                    'type' => 'string',
                    'length' => 255,
                    'nullable' => true,
                ];
                $meta->mapField($config['mappings'][static::UPDATEDBY_PROPERTY]);
            }
        }

        parent::readExtendedMetadata($meta, $config);
    }
}
