<?php


namespace Pars\Model\Import;


use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class ImportBeanFinder
 * @package Pars\Model\Import
 */
class ImportBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('Import_ID', 'Import_ID', 'Import', 'Import_ID', true);
        $loader->addColumn('Article_ID', 'Article_ID', 'Import', 'Import_ID');
        $loader->addColumn('Import_Name', 'Import_Name', 'Import', 'Import_ID');
        $loader->addColumn('ImportType_Code', 'ImportType_Code', 'Import', 'Import_ID');
        $loader->addColumn('Import_Data', 'Import_Data', 'Import', 'Import_ID');
        $loader->addColumn('Import_Active', 'Import_Active', 'Import', 'Import_ID');
        $loader->addColumn('Import_Day', 'Import_Day', 'Import', 'Import_ID');
        $loader->addColumn('Import_Hour', 'Import_Hour', 'Import', 'Import_ID');
        $loader->addColumn('Import_Minute', 'Import_Minute', 'Import', 'Import_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'Import', 'Import_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Import', 'Import_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'Import', 'Import_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Import', 'Import_ID');
        parent::__construct($loader, new ImportBeanFactory());
    }
}
