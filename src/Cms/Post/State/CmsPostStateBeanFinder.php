<?php

namespace Pars\Model\Cms\Post\State;

use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Cms\Post\CmsPostBeanList;

/**
 * Class CmsPostStateBeanFinder
 * @package Pars\Model\Cms\Post\State
 * @method CmsPostStateBean getBean(bool $fetchAllData = false)
 * @method CmsPostBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPostStateBeanFinder extends AbstractDatabaseBeanFinder
{

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('CmsPostState_Code', 'CmsPostState_Code', 'CmsPostState', 'CmsPostState_Code', true);
        $loader->addColumn('CmsPostState_Active', 'CmsPostState_Active', 'CmsPostState', 'CmsPostState_Code');
    }


    public function setCmsPostState_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsPostState_Active', $active);
        return $this;
    }
}
