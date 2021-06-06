<?php

namespace Pars\Model\Cms\Menu\Type;

use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsMenuTypeBeanFinder
 * @package Pars\Model\Cms\Menu\Type
 * @method CmsMenuTypeBean getBean(bool $fetchAllData = false)
 * @method CmsMenuTypeBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsMenuTypeBeanFinder extends AbstractDatabaseBeanFinder
{

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('CmsMenuType_Code', 'CmsMenuType_Code', 'CmsMenuType', 'CmsMenuType_Code', true);
        $loader->addColumn('CmsMenuType_Active', 'CmsMenuType_Active', 'CmsMenuType', 'CmsMenuType_Code');
    }


    public function setCmsMenuType_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsMenuType_Active', $active);
        return $this;
    }
}
