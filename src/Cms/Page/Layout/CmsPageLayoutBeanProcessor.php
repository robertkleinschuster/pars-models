<?php

namespace Pars\Model\Cms\Page\Layout;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsPageLayoutBeanProcessor
 * @package Pars\Model\Cms\Page\Layout
 */
class CmsPageLayoutBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('CmsPageLayout_Code', 'CmsPageLayout_Code', 'CmsPageLayout', 'CmsPageLayout_Code', true);
        $saver->addColumn('CmsPageLayout_Active', 'CmsPageLayout_Active', 'CmsPageLayout', 'CmsPageLayout_Code');
    }

    protected function initValidator()
    {
    }


}
