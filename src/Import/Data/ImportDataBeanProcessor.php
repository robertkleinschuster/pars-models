<?php


namespace Pars\Model\Import\Data;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class ImportDataBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('ImportData.ImportData_ID')->setKey(true);
        $saver->addField('ImportData.Import_ID');
        $saver->addField('ImportData.ImportData_Data');
        $saver->addField('ImportData.ImportData_IntValue1');
        $saver->addField('ImportData.ImportData_IntValue2');
        $saver->addField('ImportData.ImportData_IntValue3');
        $saver->addField('ImportData.ImportData_StringValue1');
        $saver->addField('ImportData.ImportData_StringValue2');
        $saver->addField('ImportData.ImportData_StringValue3');
        $saver->addDefaultFields('ImportData');
    }

    protected function initValidator()
    {
    }

}
