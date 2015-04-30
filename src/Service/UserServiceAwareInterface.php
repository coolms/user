<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Service;

interface UserServiceAwareInterface
{
    /**
     * @return UserServiceInterface
     */
    public function getUserService();

    /**
     * @param UserServiceInterface $userService
     */
    public function setUserService(UserServiceInterface $userService);
}