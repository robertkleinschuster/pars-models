<?php


namespace Pars\Model\Import;


use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class ImportBeanProcessor
 * @package Pars\Model\Import
 */
class ImportBeanProcessor extends AbstractBeanProcessor
{
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('Import_ID', 'Import_ID', 'Import', 'Import_ID', true);
        $saver->addColumn('Import_Name', 'Import_Name', 'Import', 'Import_ID');
        $saver->addColumn('Import_Data', 'Import_Data', 'Import', 'Import_ID');
        $saver->addColumn('Import_Active', 'Import_Active', 'Import', 'Import_ID');
        $saver->addColumn('Import_Day', 'Import_Day', 'Import', 'Import_ID');
        $saver->addColumn('Import_Hour', 'Import_Hour', 'Import', 'Import_ID');
        $saver->addColumn('Import_Minute', 'Import_Minute', 'Import', 'Import_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'Import', 'Import_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Import', 'Import_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'Import', 'Import_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Import', 'Import_ID');
        parent::__construct($saver);
    }

}