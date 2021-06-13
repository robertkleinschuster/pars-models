<?php


namespace Pars\Model\Import\Data;


use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class ImportDataBeanFinder
 * @package Pars\Model\Import\Data
 * @method ImportDataBeanFactory getBeanFactory()
 * @method ImportDataBean getBean(bool $fetchAllData = false)
 * @method ImportDataBeanList getBeanList(bool $fetchAllData = false)
 */
class ImportDataBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function initLoader(DatabaseBeanLoader $loader)
    {
       $loader->addField('ImportData.ImportData_ID')->setKey(true);
       $loader->addField('ImportData.Import_ID');
       $loader->addField('ImportData.ImportData_Data');
       $loader->addField('ImportData.ImportData_IntValue1');
       $loader->addField('ImportData.ImportData_IntValue2');
       $loader->addField('ImportData.ImportData_IntValue3');
       $loader->addField('ImportData.ImportData_StringValue1');
       $loader->addField('ImportData.ImportData_StringValue2');
       $loader->addField('ImportData.ImportData_StringValue3');
       $loader->addDefaultFields('ImportData');
    }

}
