<?php
/**
 * CoolMS2 User Module (http://www.coolms.com/)
 *
 * @link      http://github.com/coolms/user for the canonical source repository
 * @copyright Copyright (c) 2006-2015 Altgraphic, ALC (http://www.altgraphic.com)
 * @license   http://www.coolms.com/license/new-bsd New BSD License
 * @author    Dmitry Popov <d.popov@altgraphic.com>
 */

namespace CmsUser\Factory\Form\Element;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    CmsUser\Form\Element\Birthday;

class BirthdayElementFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $elements)
    {
        $services = $elements->getServiceLocator();
        return $this->configureElement(new Birthday('birthday'), $services);
    }

    /**
     * @param Birthday $element
     * @param ServiceLocatorInterface $services
     * @return Birthday
     */
    protected function configureElement(Birthday $element, ServiceLocatorInterface $services)
    {
        /* @var $options \CmsUser\Options\ModuleOptionsInterface */
        $options = $services->get('CmsUser\\Options\\ModuleOptions');

        $year = (new \DateTime('now'))->format('Y');
        $element->setOptions([
            'label'                 => 'When were you born?',
            'create_empty_option'   => true,
            'min_year'              => $year - 100,
            'max_year'              => $year - 18,
            'day_attributes' => [
                'required' => true,
            ],
            'month_attributes' => [
                'required' => true,
            ],
            'year_attributes' => [
                'required' => true,
            ],
        ]);

        return $element;
    }
}
