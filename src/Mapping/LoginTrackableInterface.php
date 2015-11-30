<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Mapping;

use DateTime;

/**
 * User login tarcking interface
 *
 * @author Dmitry Popov <d.popov@altgraphic.com>
 */
interface LoginTrackableInterface
{
    /**
     * Set loginAt
     *
     * @param DateTime $loginAt
     * @return self
     */
    public function setLoginAt(DateTime $loginAt);

    /**
     * Get loginAt
     *
     * @return DateTime
     */
    public function getLoginAt();
}
