<?php

namespace Pars\Model\Cms\Block\Type;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class CmsBlockTypeBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('CmsBlockType_Code', 'CmsBlockType_Code', 'CmsBlockType', 'CmsBlockType_Code', true);
        $saver->addColumn('CmsBlockType_Active', 'CmsBlockType_Active', 'CmsBlockType', 'CmsBlockType_Code');
    }

    protected function initValidator()
    {
    }


}
