<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Mapping\Traits;

use CmsUser\Mapping\UserInterface;

trait UpdatableTrait
{
    /**
     * @var UserInterface
     *
     * @ORM\Blameable(on="update")
     * @Form\Exclude()
     */
    protected $updatedBy;

    /**
     * Sets updatedBy
     *
     * @param UserInterface $updatedBy
     * @return self
     */
    public function setUpdatedBy(UserInterface $updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Retrieves updatedBy
     *
     * @return UserInterface
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}
