<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Persistence;

use CmsCommon\Crypt\PasswordServiceProviderInterface,
    CmsCommon\Persistence\MapperInterface,
    CmsUser\Mapping\UserInterface;

interface UserMapperInterface extends MapperInterface, PasswordServiceProviderInterface
{
    /**
     * @param array $fields
     * @return self
     */
    public function setIdentityFields(array $fields);

    /**
     * @return array
     */
    public function getIdentityFields();

    /**
     * @param mixed $identity
     * @return UserInterface|null
     */
    public function findByIdentity($identity);
}
