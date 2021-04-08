<?php

namespace Pars\Model\Cms\Menu\State;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsMenuStateBeanFinder
 * @package Pars\Model\Cms\Menu\State
 * @method CmsMenuStateBean getBean(bool $fetchAllData = false)
 * @method CmsMenuStateBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsMenuStateBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsMenuState_Code', 'CmsMenuState_Code', 'CmsMenuState', 'CmsMenuState_Code', true);
        $loader->addColumn('CmsMenuState_Active', 'CmsMenuState_Active', 'CmsMenuState', 'CmsMenuState_Code');
        parent::__construct($loader, new CmsMenuStateBeanFactory());
    }

    public function setCmsMenuState_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsMenuState_Active', $active);
        return $this;
    }
}
