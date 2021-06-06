<?php

namespace Pars\Model\Cms\Page\State;

use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsPageStateBeanProcessor
 * @package Pars\Model\Cms\Page\State
 */
class CmsPageStateBeanProcessor extends AbstractDatabaseBeanProcessor
{

    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('CmsPageState_Code', 'CmsPageState_Code', 'CmsPageState', 'CmsPageState_Code', true);
        $saver->addColumn('CmsPageState_Active', 'CmsPageState_Active', 'CmsPageState', 'CmsPageState_Code');

    }

    protected function initValidator()
    {
    }
}
