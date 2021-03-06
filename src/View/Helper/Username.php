<?php 
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\View\Helper;

use Zend\View\Helper\AbstractHelper,
    CmsUser\Mapping\UserInterface,
    CmsUser\Options\ViewHelperServiceOptionsInterface,
    CmsUser\View\Exception\DomainException;

class Username extends AbstractHelper
{
    /**
     * @var ViewHelperServiceOptionsInterface
     */
    protected $options;

    /**
     * __construct
     *
     * @param ViewHelperServiceOptionsInterface $options
     */
    public function __construct(ViewHelperServiceOptionsInterface $options)
    {
        $this->options = $options;
    }

    /**
     * __invoke
     *
     * @access public
     * @param UserInterface $user
     * @throws DomainException
     * @return string
     */
    public function __invoke(UserInterface $user = null)
    {
        if (null === $user) {
            if (!method_exists($this->getView(), 'plugin')) {
                return;
            }
            if (!($plugin = $this->getView()->plugin('cmsIdentity'))) {
                return;
            }
            if (!($user = $plugin())) {
                return 'guest';
            }
            if (!$user instanceof UserInterface) {
                throw new DomainException(sprintf(
                    '$user is not an instance of %s',
                    UserInterface::class
                ), 500);
            }
        }

        $username = null;

        if ($this->options->getEnableUsername()) {
            $username = $user->getUsername();
        }
        if (null === $username) {
            $username = $user->getEmail();
        }
        
        return $username;
    }
}
