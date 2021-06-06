<?php

namespace Pars\Model\Cms\Page\Layout;


use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsPageLayoutBeanFinder
 * @package Pars\Model\Cms\Page\Layout
 * @method CmsPageLayoutBean getBean(bool $fetchAllData = false)
 * @method CmsPageLayoutBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPageLayoutBeanFinder extends AbstractDatabaseBeanFinder
{


    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('CmsPageLayout_Code', 'CmsPageLayout_Code', 'CmsPageLayout', 'CmsPageLayout_Code', true);
        $loader->addColumn('CmsPageLayout_Active', 'CmsPageLayout_Active', 'CmsPageLayout', 'CmsPageLayout_Code');
    }


    public function setCmsPageLayout_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsPageLayout_Active', $active);
        return $this;
    }
}
