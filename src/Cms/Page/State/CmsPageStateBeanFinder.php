<?php

namespace Pars\Model\Cms\Page\State;

use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsPageStateBeanFinder
 * @package Pars\Model\Cms\Page\State
 * @method CmsPageStateBean getBean(bool $fetchAllData = false)
 * @method CmsPageStateBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPageStateBeanFinder extends AbstractDatabaseBeanFinder
{


    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('CmsPageState_Code', 'CmsPageState_Code', 'CmsPageState', 'CmsPageState_Code', true);
        $loader->addColumn('CmsPageState_Active', 'CmsPageState_Active', 'CmsPageState', 'CmsPageState_Code');
    }


    public function setCmsPageState_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsPageState_Active', $active);
        return $this;
    }
}
