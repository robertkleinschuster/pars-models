<?php

namespace Pars\Model\Cms\Block\Type;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Cms\Block\CmsBlockBean;
use Pars\Model\Cms\Block\CmsBlockBeanList;

/**
 * Class CmsBlockTypeBeanFinder
 * @package Pars\Model\Cms\Block\Type
 * @method CmsBlockBean getBean(bool $fetchAllData = false)
 * @method CmsBlockBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsBlockTypeBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsBlockType_Code', 'CmsBlockType_Code', 'CmsBlockType', 'CmsBlockType_Code', true);
        $loader->addColumn('CmsBlockType_Active', 'CmsBlockType_Active', 'CmsBlockType', 'CmsBlockType_Code');
        $loader->addColumn('CmsBlockType_Order', 'CmsBlockType_Order', 'CmsBlockType', 'CmsBlockType_Code');
        $this->order(['CmsBlockType_Order' => self::ORDER_MODE_DESC]);
        parent::__construct($loader, new CmsBlockTypeBeanFactory());
    }

    public function setCmsBlockType_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsBlockType_Active', $active);
        return $this;
    }
}
