<?php

namespace Pars\Model\Cms\PageBlock;

use Pars\Bean\Processor\OrderMetaFieldHandlerInterface;
use Pars\Bean\Validator\FieldNotEmptyBeanValidator;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsPageBlockBeanProcessor
 * @package Pars\Model\Cms\PageBlock
 */
class CmsPageBlockBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initMetaFieldHandler()
    {
        $this->addMetaFieldHandler(new OrderMetaFieldHandlerInterface(new CmsPageBlockBeanFinder($this->getDatabaseAdapter()), 'CmsPage_CmsBlock_Order', 'CmsPage_ID'));
    }


    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPage_CmsBlock', 'CmsPage_ID', true);
        $saver->addColumn('CmsBlock_ID', 'CmsBlock_ID', 'CmsPage_CmsBlock', 'CmsBlock_ID', true);
        $saver->addColumn('CmsPage_CmsBlock_Order', 'CmsPage_CmsBlock_Order', 'CmsPage_CmsBlock', 'CmsBlock_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'CmsPage_CmsBlock', 'CmsBlock_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'CmsPage_CmsBlock', 'CmsBlock_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'CmsPage_CmsBlock', 'CmsBlock_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'CmsPage_CmsBlock', 'CmsBlock_ID');
    }

    protected function initValidator()
    {
        $this->addDeleteValidator(new FieldNotEmptyBeanValidator('CmsPage_ID'));
        $this->addDeleteValidator(new FieldNotEmptyBeanValidator('CmsBlock_ID'));
    }


}
