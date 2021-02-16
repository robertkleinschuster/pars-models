<?php

namespace Pars\Model\Cms\Post\State;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Cms\Post\CmsPostBeanList;

/**
 * Class CmsPostStateBeanFinder
 * @package Pars\Model\Cms\Post\State
 * @method CmsPostStateBean getBean(bool $fetchAllData = false)
 * @method CmsPostBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPostStateBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsPostState_Code', 'CmsPostState_Code', 'CmsPostState', 'CmsPostState_Code', true);
        $loader->addColumn('CmsPostState_Active', 'CmsPostState_Active', 'CmsPostState', 'CmsPostState_Code');
        parent::__construct($loader, new CmsPostStateBeanFactory());
    }

    public function setCmsPostState_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsPostState_Active', $active);
        return $this;
    }
}
