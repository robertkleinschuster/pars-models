<?php


namespace Pars\Model\Config;


use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

class ConfigBeanProcessor extends AbstractBeanProcessor
{
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('Config_Code', 'Config_Code', 'Config', 'Config_Code', true);
        $saver->addColumn('Config_Value', 'Config_Value', 'Config', 'Config_Code');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'Config', 'Config_Code');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Config', 'Config_Code');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'Config', 'Config_Code');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Config', 'Config_Code');

        parent::__construct($saver);
    }
}