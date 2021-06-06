<?php

namespace Pars\Model\Cms\Menu\Type;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsMenuTypeBeanProcessor
 * @package Pars\Model\Cms\Menu\Type
 */
class CmsMenuTypeBeanProcessor extends AbstractDatabaseBeanProcessor
{

    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('CmsMenuType_Code', 'CmsMenuType_Code', 'CmsMenuType', 'CmsMenuType_Code', true);
        $saver->addColumn('CmsMenuType_Active', 'CmsMenuType_Active', 'CmsMenuType', 'CmsMenuType_Code');
    }


    protected function initValidator()
    {
    }


}
