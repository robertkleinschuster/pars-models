<?php

namespace Pars\Model\Cms\Page\State;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsPageStateBeanFinder
 * @package Pars\Model\Cms\Page\State
 */
class CmsPageStateBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsPageState_Code', 'CmsPageState_Code', 'CmsPageState', 'CmsPageState_Code', true);
        $loader->addColumn('CmsPageState_Active', 'CmsPageState_Active', 'CmsPageState', 'CmsPageState_Code');
        parent::__construct($loader, new CmsPageStateBeanFactory());
    }

    public function setCmsPageState_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsPageState_Active', $active);
        return $this;
    }
}
