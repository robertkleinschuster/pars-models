<?php

namespace Pars\Model\Cms\Block\State;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class CmsBlockStateBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('CmsBlockState_Code', 'CmsBlockState_Code', 'CmsBlockState', 'CmsBlockState_Code', true);
        $saver->addColumn('CmsBlockState_Active', 'CmsBlockState_Active', 'CmsBlockState', 'CmsBlockState_Code');
    }

    protected function initValidator()
    {
    }
}
