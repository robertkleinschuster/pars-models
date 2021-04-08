<?php

namespace Pars\Model\Cms\Post\Type;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsPostTypeBeanFinder
 * @package Pars\Model\Cms\Post\Type
 * @method CmsPostTypeBean getBean(bool $fetchAllData = false)
 * @method CmsPostTypeBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPostTypeBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsPostType_Code', 'CmsPostType_Code', 'CmsPostType', 'CmsPostType_Code', true);
        $loader->addColumn('CmsPostType_Template', 'CmsPostType_Template', 'CmsPostType', 'CmsPostType_Code');
        $loader->addColumn('CmsPostType_Active', 'CmsPostType_Active', 'CmsPostType', 'CmsPostType_Code');
        parent::__construct($loader, new CmsPostTypeBeanFactory());
    }

    public function setCmsPostType_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsPostType_Active', $active);
        return $this;
    }
}
