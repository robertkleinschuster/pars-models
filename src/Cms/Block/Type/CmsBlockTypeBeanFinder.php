<?php

namespace Pars\Model\Cms\Block\Type;


use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Cms\Block\CmsBlockBean;
use Pars\Model\Cms\Block\CmsBlockBeanList;

/**
 * Class CmsBlockTypeBeanFinder
 * @package Pars\Model\Cms\Block\Type
 * @method CmsBlockBean getBean(bool $fetchAllData = false)
 * @method CmsBlockBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsBlockTypeBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('CmsBlockType_Code', 'CmsBlockType_Code', 'CmsBlockType', 'CmsBlockType_Code', true);
        $loader->addColumn('CmsBlockType_Active', 'CmsBlockType_Active', 'CmsBlockType', 'CmsBlockType_Code');
        $loader->addColumn('CmsBlockType_Order', 'CmsBlockType_Order', 'CmsBlockType', 'CmsBlockType_Code');
    }


    public function setCmsBlockType_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsBlockType_Active', $active);
        return $this;
    }

    public function orderByOrderField()
    {
        $this->order(['CmsBlockType_Order' => self::ORDER_MODE_ASC]);
        return $this;
    }
}
