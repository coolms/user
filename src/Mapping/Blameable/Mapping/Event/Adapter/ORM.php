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
    public function remap($meta, array $mappings, $value)
    {
        if (!$mappings) {
            return;
        }

        foreach ($mappings as $field => $mapping) {
            if (is_object($value) || null === $value) {

                if ($meta->hasField($field)) {
                    unset($meta->fieldMappings[$field]);
                }

                $meta->mapManyToOne([
                    'fieldName' => $field,
                    'targetEntity' => 'CmsUser\\Mapping\\UserInterface',
                    'cascade' => ['persist', 'detach'],
                    'joinColumns' => [
                        [
                            'nullable' => $mapping['nullable'],
                            'onDelete' => $mapping['nullable'] ? 'SET NULL' : 'RESTRICT',
                            'onUpdate' => 'CASCADE',
                        ],
                    ],
                ]);
            }
        }
    }
}
