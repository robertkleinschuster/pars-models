<?php

namespace Pars\Model\Cms\Menu\Type;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsMenuTypeBeanFinder
 * @package Pars\Model\Cms\Menu\Type
 * @method CmsMenuTypeBean getBean(bool $fetchAllData = false)
 * @method CmsMenuTypeBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsMenuTypeBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsMenuType_Code', 'CmsMenuType_Code', 'CmsMenuType', 'CmsMenuType_Code', true);
        $loader->addColumn('CmsMenuType_Active', 'CmsMenuType_Active', 'CmsMenuType', 'CmsMenuType_Code');
        parent::__construct($loader, new CmsMenuTypeBeanFactory());
    }

    public function setCmsMenuType_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsMenuType_Active', $active);
        return $this;
    }
}
