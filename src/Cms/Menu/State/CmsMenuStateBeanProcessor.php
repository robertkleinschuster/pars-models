<?php

namespace Pars\Model\Cms\Menu\State;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsMenuStateBeanProcessor
 * @package Pars\Model\Cms\Menu\State
 */
class CmsMenuStateBeanProcessor extends AbstractDatabaseBeanProcessor
{


    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('CmsMenuState_Code', 'CmsMenuState_Code', 'CmsMenuState', 'CmsMenuState_Code', true);
        $saver->addColumn('CmsMenuState_Active', 'CmsMenuState_Active', 'CmsMenuState', 'CmsMenuState_Code');
    }

    protected function initValidator()
    {
    }

}
