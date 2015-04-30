<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Entity;

use Zend\Form\Annotation as Form,
    Doctrine\ORM\Mapping as ORM,
    Gedmo\Mapping\Annotation as Gedmo,
    CmsDoctrine\Mapping\Translatable\TranslatableInterface,
    CmsDoctrineORM\Mapping\Common\MappedSuperclass\AbstractIdentifiableEntity,
    CmsDoctrineORM\Mapping\Translatable\Traits\TranslatableTrait;

/**
 * Security question
 *
 * @Gedmo\TranslationEntity(class="CmsUser\Entity\Translations\QuestionTranslation")
 * @ORM\Entity(repositoryClass="CmsUser\Entity\Repository\QuestionRepository")
 * @ORM\Table(name="user_questions")
 */
class Question extends AbstractIdentifiableEntity implements TranslatableInterface
{
    use TranslatableTrait {
            TranslatableTrait::__construct as private __translatableConstruct;
        }

    /**
     * __construct
     *
     * Initializes translations
     */
    public function __construct()
    {
        $this->__translatableConstruct();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="question",type="string",length=255,nullable=false,unique=true)
     * @Gedmo\Translatable
     * @Form\Type("Text")
     */
    protected $question;

    /**
     * Set question
     *
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
