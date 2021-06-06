<?php

namespace Pars\Model\Cms\Menu\State;


use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsMenuStateBeanFinder
 * @package Pars\Model\Cms\Menu\State
 * @method CmsMenuStateBean getBean(bool $fetchAllData = false)
 * @method CmsMenuStateBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsMenuStateBeanFinder extends AbstractDatabaseBeanFinder
{


    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('CmsMenuState_Code', 'CmsMenuState_Code', 'CmsMenuState', 'CmsMenuState_Code', true);
        $loader->addColumn('CmsMenuState_Active', 'CmsMenuState_Active', 'CmsMenuState', 'CmsMenuState_Code');
        // TODO: Implement initLoader() method.
    }


    public function setCmsMenuState_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsMenuState_Active', $active);
        return $this;
    }
}
