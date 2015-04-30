<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Entity\Translations;

use Doctrine\ORM\Mapping as ORM,
    CmsDoctrineORM\Mapping\Translatable\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_question_translations",
 *      uniqueConstraints={@ORM\UniqueConstraint(columns={"locale","object_id","field"})})
 */
class QuestionTranslation extends AbstractTranslation
{
    /**
     * All required columns are mapped through inherited superclass
     */
}
