<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Mapping\Blameable\Traits;

use CmsUser\Mapping\UserInterface;

trait CreatableTrait
{
    /**
     * @var UserInterface
     *
     * @Gedmo\Blameable(on="create")
     * @Form\Exclude()
     */
    protected $createdBy;

    /**
     * Sets createdBy
     *
     * @param UserInterface $createdBy
     */
    public function setCreatedBy(UserInterface $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * Retrieves createdBy
     *
     * @return UserInterface
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
