<?php

namespace Pars\Model\Cms\Post\Type;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsPostTypeBeanProcessor
 * @package Pars\Model\Cms\Post\Type
 */
class CmsPostTypeBeanProcessor extends AbstractDatabaseBeanProcessor
{

    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('CmsPostType_Code', 'CmsPostType_Code', 'CmsPostType', 'CmsPostType_Code', true);
        $saver->addColumn('CmsPostType_Template', 'CmsPostType_Template', 'CmsPostType', 'CmsPostType_Code', true);
        $saver->addColumn('CmsPostType_Active', 'CmsPostType_Active', 'CmsPostType', 'CmsPostType_Code');

    }

    protected function initValidator()
    {
    }


}
