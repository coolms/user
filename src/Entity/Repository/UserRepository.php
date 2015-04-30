<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Entity\Repository;

use Doctrine\ORM\Query,
    CmsDoctrineORM\Mapping\Common\Repository\EntityRepository,
    CmsCommon\Crypt\PasswordServiceProviderTrait,
    CmsUser\Mapping\UserInterface,
    CmsUser\Persistence\UserMapperInterface;

/**
 * UserRepository
 *
 * Repository class to extend Doctrine ORM functions with your own
 * using DQL language.
 */
class UserRepository extends EntityRepository implements UserMapperInterface
{
    use PasswordServiceProviderTrait;

    /**
     * @var array
     */
    protected $identityFields = [];

    /**
     * {@inheritDoc}
     */
    public function setIdentityFields(array $fields)
    {
        $this->identityFields = $fields;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getIdentityFields()
    {
        return $this->identityFields;
    }

    /**
     * {@inheritDoc}
     */
    public function findByIdentity($identity)
    {
        $fields     = $this->getIdentityFields();
        $criteria   = array_combine($fields, array_fill(0, sizeof($fields), $identity));

        return $this->findAnyOneBy($criteria);
    }

    /**
     * @param array $criteria
     * @return UserInterface|null
     */
    public function findAnyOneBy(array $criteria)
    {
        $qb  = $this->createQueryBuilder('u');
        $orX = $qb->expr()->orX();

        $values = array_values($criteria);
        $fields = array_keys($criteria);
        foreach ($fields as $key => $field) {
            $orX->add("u.$field = ?$key");
            $qb->setParameter($key, array_shift($values));
        }

        return $qb->where($orX)
                  ->setMaxResults(1)
                  ->getQuery()
                  ->getOneOrNullResult(Query::HYDRATE_OBJECT);
    }
}
