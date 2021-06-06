<?php

namespace Pars\Model\File\Type;

use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class FileTypeBeanProcessor
 * @package Pars\Model\File\Type
 */
class FileTypeBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('FileType_Code', 'FileType_Code', 'FileType', 'FileType_Code', true);
        $saver->addColumn('FileType_Name', 'FileType_Name', 'FileType', 'FileType_Code');
        $saver->addColumn('FileType_Mime', 'FileType_Mime', 'FileType', 'FileType_Code');
        $saver->addColumn('FileType_Active', 'FileType_Active', 'FileType', 'FileType_Code');
    }

    protected function initValidator()
    {
    }


}
