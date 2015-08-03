<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Options;

use CmsCommon\Form\Options\FormOptionsInterface as CommonFormOptionsInterface;

interface FormOptionsInterface extends CommonFormOptionsInterface
{
    /**
     * Set enable username.
     *
     * @param bool $flag
     * @return self
     */
    public function setEnableUsername($flag);

    /**
     * Get enable username.
     *
     * @return bool
     */
    public function getEnableUsername();

    /**
     * Get user entity class name.
     *
     * @return string
     */
    public function getUserEntityClass();
}
