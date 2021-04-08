<?php

namespace Pars\Model\Cms\Block\State;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Cms\Block\CmsBlockBean;
use Pars\Model\Cms\Block\CmsBlockBeanList;

/**
 * Class CmsBlockStateBeanFinder
 * @package Pars\Model\Cms\Block\State
 * @method CmsBlockBean getBean(bool $fetchAllData = false)
 * @method CmsBlockBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsBlockStateBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsBlockState_Code', 'CmsBlockState_Code', 'CmsBlockState', 'CmsBlockState_Code', true);
        $loader->addColumn('CmsBlockState_Active', 'CmsBlockState_Active', 'CmsBlockState', 'CmsBlockState_Code');
        parent::__construct($loader, new CmsBlockStateBeanFactory());
    }

    public function setCmsBlockState_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsBlockState_Active', $active);
        return $this;
    }
}
