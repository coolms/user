<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Mapping\Blameable\Mapping\Event\Adapter;

use Gedmo\Mapping\Event\Adapter\ORM as BaseAdapterORM,
    CmsUser\Mapping\Blameable\Mapping\Event\BlameableAdapter;

/**
 * Doctrine event adapter for ORM adapted
 * for Blameable behavior.
 */
final class ORM extends BaseAdapterORM implements BlameableAdapter
{
    /**
     * {@inheritDoc}
     */
    public function remapFieldsToAssociations($meta, array $fields)
    {
        foreach ($fields as $field) {
            if (!$meta->hasField($field)) {
                continue;
            }

            $mapping = [
                'fieldName' => $field,
                'targetEntity' => 'CmsUser\\Mapping\\UserInterface',
            ];

            if ($meta->isInheritedField($field)) {
                $mapping['inherited'] = $meta->fieldMappings[$field]['inherited'];
            } else {
                $mapping['cascade'] = ['persist', 'detach'];
                $nullable = (bool) $meta->fieldMappings[$field]['nullable'];
                $mapping['joinColumns'] = [
                    [
                        'nullable' => $nullable,
                        'onDelete' => $nullable ? 'SET NULL' : 'RESTRICT',
                        'onUpdate' => 'CASCADE',
                    ],
                ];
            }

            unset($meta->fieldMappings[$field]);
            $meta->mapManyToOne($mapping);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function remapAssociationsToFields($meta, array $fields)
    {
        foreach ($fields as $field) {
            if (!$meta->hasAssociation($field)) {
                continue;
            }

            $mapping = [
                'fieldName' => $field,
                'type' => 'string',
                'length' => 255,
            ];

            if ($meta->isInheritedAssociation($field)) {
                $mapping['inherited'] = $meta->associationMappings[$field]['inherited'];
            } elseif (isset($meta->associationMappings[$field]['joinColumns'][0]['nullable'])) {
                $mapping['nullable'] = (bool) $meta->associationMappings[$field]['joinColumns'][0]['nullable'];
            }

            unset($meta->associationMappings[$field]);
            $meta->mapField($mapping);
        }
    }
}
