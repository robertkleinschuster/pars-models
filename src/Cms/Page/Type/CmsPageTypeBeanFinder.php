<?php

namespace Pars\Model\Cms\Page\Type;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

class CmsPageTypeBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsPageType_Code', 'CmsPageType_Code', 'CmsPageType', 'CmsPageType_Code', true);
        $loader->addColumn('CmsPageType_Active', 'CmsPageType_Active', 'CmsPageType', 'CmsPageType_Code');
        parent::__construct($loader, new CmsPageTypeBeanFactory());
    }

    public function setCmsPageType_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsPageType_Active', $active);
        return $this;
    }
}
