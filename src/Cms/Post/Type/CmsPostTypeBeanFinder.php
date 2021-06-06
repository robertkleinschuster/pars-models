<?php

namespace Pars\Model\Cms\Post\Type;

use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsPostTypeBeanFinder
 * @package Pars\Model\Cms\Post\Type
 * @method CmsPostTypeBean getBean(bool $fetchAllData = false)
 * @method CmsPostTypeBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPostTypeBeanFinder extends AbstractDatabaseBeanFinder
{

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('CmsPostType_Code', 'CmsPostType_Code', 'CmsPostType', 'CmsPostType_Code', true);
        $loader->addColumn('CmsPostType_Template', 'CmsPostType_Template', 'CmsPostType', 'CmsPostType_Code');
        $loader->addColumn('CmsPostType_Active', 'CmsPostType_Active', 'CmsPostType', 'CmsPostType_Code');
    }


    public function setCmsPostType_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsPostType_Active', $active);
        return $this;
    }
}
