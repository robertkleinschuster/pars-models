<?php

namespace Pars\Model\Cms\Page\Type;

use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class CmsPageTypeBeanFinder
 * @package Pars\Model\Cms\Page\Type
 * @method CmsPageTypeBean getBean(bool $fetchAllData = false)
 * @method CmsPageTypeBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPageTypeBeanFinder extends AbstractDatabaseBeanFinder
{

    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new CmsPageTypeBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('CmsPageType_Code', 'CmsPageType_Code', 'CmsPageType', 'CmsPageType_Code', true);
        $loader->addColumn('CmsPageType_Active', 'CmsPageType_Active', 'CmsPageType', 'CmsPageType_Code');
        $loader->addColumn('CmsPageType_Order', 'CmsPageType_Order', 'CmsPageType', 'CmsPageType_Code');
    }


    public function orderByOrderField()
    {
        $this->order(['CmsPageType_Order' => self::ORDER_MODE_ASC]);
        return $this;
    }

    public function setCmsPageType_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('CmsPageType_Active', $active);
        return $this;
    }
}
