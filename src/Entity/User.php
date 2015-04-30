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
    Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM,
    Gedmo\Mapping\Annotation as Gedmo,
    CmsDoctrineORM\Mapping\Dateable\MappedSuperclass\AbstractTimestampableEntity,
    CmsDoctrineORM\Mapping\Dateable\Traits\ExpirableTrait,
    CmsDoctrineORM\Mapping\Common\Traits\StateableTrait,
    CmsUser\Mapping\UserInterface,
    CmsUser\Mapping\LoginTrackableInterface,
    CmsAuthorization\Mapping\RoleableInterface,
    CmsAuthorization\Mapping\Traits\RoleableTrait,
    CmsLocale\Mapping\LocalizableInterface,
    CmsLocale\Mapping\Traits\LocalizableTrait,
    CmsUserExt\Mapping\MetadatableInterface as ExtMetadatableInterface,
    CmsUserExt\Mapping\Traits\MetadatableTrait as ExtMetadatableTrait,
    CmsUserOrg\Mapping\OrgMetadatableInterface,
    CmsUserOrg\Mapping\Traits\OrgMetadatableTrait,
    CmsUserShoppingCart\Mapping\CartableInterface,
    CmsUserShoppingCart\Mapping\Traits\CartableTrait,
    CmsIhunt\Mapping\HunterableInterface,
    CmsIhunt\Mapping\Traits\HunterableTrait,
    CmsFile\Mapping\FileableInterface,
    CmsFile\Mapping\Traits\FileableTrait,
    CmsUserPurse\Mapping\PurseableInterface,
    CmsUserPurse\Mapping\Traits\PurseableTrait;

/**
 * An implemention of a role aware user entity
 *
 * @ORM\Entity(repositoryClass="CmsUser\Entity\Repository\UserRepository")
 * @ORM\Table(name="users",indexes={
 *      @ORM\Index(columns={"username","email","first_name",
 *          "second_name","last_name","registration_token"})
 *      })
 * @ORM\RelationOverrides({
 *      @ORM\RelationOverride(name="extMetadata",
 *          targetEntity="CmsUserExt\Mapping\MetadataInterface",
 *          type="ONE_TO_ONE",
 *          mappedBy="user",
 *          orphanRemoval=true,
 *          cascade={"persist","remove"}),
 *      @ORM\RelationOverride(name="orgMetadata",
 *          targetEntity="CmsUserOrg\Mapping\MetadataInterface",
 *          type="ONE_TO_MANY",
 *          mappedBy="user",
 *          orphanRemoval=true,
 *          cascade={"persist","remove"}),
 *      @ORM\RelationOverride(name="shoppingCarts",
 *          targetEntity="CmsUserShoppingCart\Mapping\CartInterface",
 *          type="ONE_TO_MANY",
 *          mappedBy="user",
 *          orphanRemoval=true,
 *          cascade={"persist","remove"},
 *          fetch="EXTRA_LAZY"),
 *      @ORM\RelationOverride(name="files",
 *          targetEntity="CmsFile\Mapping\FileInterface",
 *          type="MANY_TO_MANY",
 *          fetch="EXTRA_LAZY"),
 *      @ORM\RelationOverride(name="purse",
 *          targetEntity="CmsUserPurse\Mapping\PurseInterface",
 *          type="ONE_TO_ONE",
 *          mappedBy="user",
 *          orphanRemoval=true,
 *          cascade={"persist","remove"})})
 * @ORM\Changeable(field={"username","email","firstName","secondName",
 *      "lastName","birthday","locale","question","answer"})
 * @Form\Name("user")
 * @Form\Hydrator("DoctrineModule\Stdlib\Hydrator\DoctrineObject")
 * @Form\Instance("CmsUser\Entity\User")
 * @Form\Options({
 *      "label":"User",
 *      "use_submit_element":true,
 *      "use_reset_element":true,
 *      })
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
class User extends AbstractTimestampableEntity implements
        UserInterface,
        LoginTrackableInterface,
        LocalizableInterface,
        RoleableInterface,
        ExtMetadatableInterface,
        OrgMetadatableInterface,
        CartableInterface,
        HunterableInterface,
        FileableInterface,
        PurseableInterface
{
    use LocalizableTrait,
        StateableTrait,
        ExpirableTrait;
    use RoleableTrait {
            RoleableTrait::__construct as private __roleableConstruct;
        }
    use ExtMetadatableTrait;
    use OrgMetadatableTrait {
            OrgMetadatableTrait::__construct as private __orgMetadatableConstruct;
        }
    use CartableTrait {
            CartableTrait::__construct as private __cartableConstruct;
        }
    use HunterableTrait;
    use FileableTrait {
            FileableTrait::__construct as private __fileableConstruct;
        }
    use PurseableTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=30,unique=true,nullable=true)
     * @Form\Type("CmsUserUsername")
     * @Form\Attributes({"maxLength":30})
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string",unique=true,length=60,nullable=false)
     * @Form\Type("CmsUserEmail")
     * @Form\Attributes({"maxLength":60})
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=60,nullable=false)
     * @Form\Type("Password")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Required(true)
     * @Form\Validator({
     *      "name":"StringLength",
     *      "options":{
     *          "encoding":"UTF-8",
     *          "min":6,
     *          "max":20,
     *          "messages":{
     *              "stringLengthTooShort":"The password must be at least %min% characters long",
     *              "stringLengthTooLong":"The password must not be more than %max% characters",
     *          },
     *      }})
     * @Form\Attributes({"required":true,"maxLength":20})
     * @Form\Options({"label":"Password"})
     */
    protected $password;

    /**
     * @var string
     *
     * @Form\Type("Password")
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Validator({"name":"CmsUserPasswordVerify"})
     * @Form\Attributes({"required":true,"maxLength":20})
     * @Form\Options({"label":"Confirm Password"})
     */
    protected $passwordVerify;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=40,nullable=true)
     * @Form\Type("Text")
     * @Form\Filter({"name":"StripTags"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Validator({"name":"StringLength","options":{"encoding":"UTF-8","max":40}})
     * @Form\Required(true)
     * @Form\Attributes({"required":true,"maxLength":40})
     * @Form\Options({"label":"Last Name"})
     */
    protected $lastName;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=40,nullable=true)
     * @Form\Type("Text")
     * @Form\Filter({"name":"StripTags"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Validator({"name":"StringLength","options":{"encoding":"UTF-8","max":40}})
     * @Form\Required(true)
     * @Form\Attributes({"required":true,"maxLength":40})
     * @Form\Options({"label":"First Name"})
     */
    protected $firstName;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=40,nullable=true)
     * @Form\Type("Text")
     * @Form\Filter({"name":"StripTags"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"Null"})
     * @Form\Required(false)
     * @Form\Validator({"name":"StringLength","options":{"encoding":"UTF-8","max":40}})
     * @Form\Attributes({"maxLength":40})
     * @Form\Options({"label":"Second Name"})
     */
    protected $secondName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime",nullable=false)
     * @Form\Type("CmsUserBirthday")
     * @Form\Required(true)
     */
    protected $birthday;

    /**
     * @var Question
     *
     * @ORM\ManyToOne(targetEntity="CmsUser\Entity\Question")
     * @ORM\JoinColumn(nullable=false)
     * @Form\Type("ObjectSelect")
     * @Form\Filter({"name":"StripTags"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Required(true)
     * @Form\AllowEmpty(true)
     * @Form\Validator({"name":"Digits"})
     * @Form\Options({
     *      "required":true,
     *      "empty_option":"Security Question",
     *      "label":"Security Question",
     *      "target_class":"CmsUser\Entity\Question",
     *      "property":"question",
     *      })
     */
    protected $question;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=100,nullable=false)
     * @Form\Type("Text")
     * @Form\Filter({"name":"StripTags"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StringToLower","options":{"encoding":"UTF-8"}})
     * @Form\Validator({"name":"StringLength","options":{
     *      "messages":{
     *          "stringLengthTooShort":"The answer must be at least %min% characters long",
     *          "stringLengthTooLong":"The answer must not be more than %max% characters",
     *      },
     *      "encoding":"UTF-8",
     *      "min":4,
     *      "max":100,
     *      }})
     * @Form\Validator({"name":"Alnum","options":{"allowWhiteSpace":true}})
     * @Form\Required(true)
     * @Form\Attributes({
     *      "autocomplete":"off",
     *      "required":true,
     *      "maxLength":100,
     *      })
     * @Form\Options({"label":"Type Your Answer"})
     */
    protected $answer;

    /**
     * @var string
     *
     * @Form\Type("Text")
     * @Form\Filter({"name":"StripTags"})
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Filter({"name":"StringToLower","options":{"encoding":"UTF-8"}})
     * @Form\Validator({"name":"CmsUserAnswerVerify"})
     * @Form\Attributes({
     *      "autocomplete":"off",
     *      "required":true,
     *      "maxLength":100,
     *      })
     * @Form\Options({"label":"Type Your Answer"})
     */
    protected $answerVerify;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=16,nullable=true)
     * @Form\Type("CmsUserMobilePhoneNumber")
     */
    protected $mobilePhoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=255,nullable=true)
     * @Form\Type("File")
     */
    protected $avatar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime",nullable=true)
     * @Form\Type("StaticElement")
     * @Form\Options({
     *      "label":"Login at",
     *      "text_domain":"default",
     *      })
     */
    protected $loginAt;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=32,unique=true,nullable=true)
     * @Form\Exclude()
     */
    protected $registrationToken;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean",nullable=false)
     * @Form\Exclude()
     */
    protected $emailConfirmed = false;

    /**
     * @var UserInterface[]
     *
     * @ORM\ManyToMany(targetEntity="CmsUser\Mapping\UserInterface",
     *      inversedBy="linked",
     *      orphanRemoval=true,
     *      cascade={"persist","remove"},
     *      fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="user_links",
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="link_id",onDelete="CASCADE")
     *      })
     * @Form\Exclude()
     * @Form\Type("ObjectSelect")
     * @Form\Attributes({"multiple":true})
     * @Form\Options({
     *      "empty_option":"Please, choose your Friends",
     *      "target_class":"CmsUser\Entity\User",
     *      "property":"displayName",
     *      "is_method":true,
     *      "find_method":{
     *          "name":"notExisitng",
     *          "params":{
     *              "criteria":{"id":"1"},
     *              "orderBy":{"id":"DESC"},
     *          }
     *      }})
     */
    protected $links;

    /**
     * @var UserInterface[]
     *
     * @ORM\ManyToMany(targetEntity="CmsUser\Mapping\UserInterface",mappedBy="links")
     * @Form\Exclude()
     */
    protected $linked;

    /**
     * __construct
     *
     * Initializes collections
     */
    public function __construct()
    {
        $this->links    = new ArrayCollection();
        $this->linked   = new ArrayCollection();
        $this->__fileableConstruct();
        $this->__roleableConstruct();
        $this->__orgMetadatableConstruct();
        $this->__cartableConstruct();
    }

    /**
     * {@inheritDoc}
     */
    public function getRoleId()
    {
        return "cms-user-{$this->getId()}";
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     * 
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     * 
     * @param string $password
     */
    public function setPasswordVerify($password)
    {
        $this->passwordVerify = $password;
    }

    /**
     * Get password
     * 
     * @return string
     */
    public function getPasswordVerify()
    {
        return $this->passwordVerify;
    }

    /**
     * Set first name
     * 
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get first name
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set second name
     * 
     * @param string $secondName
     */
    public function setSecondName($secondName)
    {
        $this->secondName = $secondName;
    }

    /**
     * Get second name
     * 
     * @return string
     */
    public function getSecondName()
    {
        return $this->secondName;
    }

    /**
     * Set last name
     * 
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Get last name
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get display name
     * 
     * @return string
     */
    public function getDisplayName()
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    /**
     * Set birthday
     * 
     * @param \DateTime $birthday
     */
    public function setBirthday(\DateTime $birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * Get birthday
     * 
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set mobile phone number
     * 
     * @param string $mobilePhoneNumber
     */
    public function setMobilePhoneNumber($mobilePhoneNumber)
    {
        $this->mobilePhoneNumber = $mobilePhoneNumber;
    }

    /**
     * Get mobile phone number
     * 
     * @return string
     */
    public function getMobilePhoneNumber()
    {
        return $this->mobilePhoneNumber;
    }

    /**
     * Set question
     * 
     * @param Question $question
     */
    public function setQuestion(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Get question
     * 
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set answer
     * 
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Get answer
     * 
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set answer
     * 
     * @param string $answer
     */
    public function setAnswerVerify($answer)
    {
        $this->answerVerify = $answer;
    }

    /**
     * Get answer
     * 
     * @return string
     */
    public function getAnswerVerify()
    {
        return $this->answerVerify;
    }

    /**
     * Set avatar
     * 
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    /**
     * Get avatar
     * 
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set registration token
     * 
     * @param string $registration token
     */
    public function setRegistrationToken($registrationToken)
    {
        $this->registrationToken = $registrationToken;
    }

    /**
     * Get registration token
     * 
     * @return string
     */
    public function getRegistrationToken()
    {
        return $this->registrationToken;
    }

    /**
     * Set is email confirmed
     * 
     * @param bool $emailConfirmed
     */
    public function setEmailConfirmed($emailConfirmed)
    {
        $this->emailConfirmed = (bool) $emailConfirmed;
    }

    /**
     * Get is email confirmed
     * 
     * @return bool
     */
    public function getEmailConfirmed()
    {
        return $this->emailConfirmed;
    }

    /**
     * Set login datetime
     *
     * @param \DateTime $loginAt
     */
    public function setLoginAt(\DateTime $loginAt)
    {
        $this->loginAt = $loginAt;
    }

    /**
     * Get login datetime
     *
     * @return \DateTime
     */
    public function getLoginAt()
    {
        return $this->loginAt;
    }

    /**
     * Get links - mandatory with ManyToMany
     * 
     * @return Collection
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Add links - mandatory with ManyToMany
     * 
     * @param Collection
     */
    public function addLinks(Collection $users)
    {
        foreach ($users as $user) {
           $this->addLink($user);
        }
    }

    /**
     * Add link
     *
     * @param User $user
     */
    public function addLink(User $user)
    {
        $user->addLinked($this); // Synchronously updating inverse side.
                                 // Tell your new friend you have added him as a friend.
        $this->links[] = $user;
    }

    /**
     * Remove links
     *
     * @param Collection $users
     */
    public function removeLinks(Collection $users)
    {
        foreach ($users as $user) {
            $this->removeLink($user);
        }
    }

    /**
     * Remove link
     * 
     * @param User $user
     */
    public function removeLink(User $user)
    {
        $user->removeLinked($this); // synchronously updating inverse side.
        $this->links->removeElement($user);
    }

    /**
     * Add linked with me
     *
     * @param User $user
     */
    public function addLinked(User $user)
    {
        $this->linked[] = $user;
    }

    /**
     * Remove linked with me
     *
     * @param User $user
     */
    public function removeLinked(User $user)
    {
        $this->linked->removeElement($user);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getDisplayName();
    }
}
