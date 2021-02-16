<?php

namespace Pars\Model\Cms\Page\Layout;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsPageLayoutBeanFinder
 * @package Pars\Model\Cms\Page\Layout
 * @method CmsPageLayoutBean getBean(bool $fetchAllData = false)
 * @method CmsPageLayoutBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPageLayoutBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsPageLayout_Code', 'CmsPageLayout_Code', 'CmsPageLayout', 'CmsPageLayout_Code', true);
        $loader->addColumn('CmsPageLayout_Active', 'CmsPageLayout_Active', 'CmsPageLayout', 'CmsPageLayout_Code');
        parent::__construct($loader, new CmsPageLayoutBeanFactory());
    }

    public function setCmsPageLayout_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsPageLayout_Active', $active);
        return $this;
    }
}
