<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Mapping\Blameable\Mapping\Event;

use Doctrine\Common\Persistence\Mapping\ClassMetadata,
    Gedmo\Blameable\Mapping\Event\BlameableAdapter as BaseBlameableAdapter;

/**
 * Doctrine event adapter interface
 * for Blameable behavior.
 */
interface BlameableAdapter extends BaseBlameableAdapter
{
    /**
     * @param ClassMetadata $meta
     * @param array $mappings
     * @param mixed $value
     */
    public function remap($meta, array $mappings, $value);
}
