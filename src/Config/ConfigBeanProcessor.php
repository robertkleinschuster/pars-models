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
        parent::__construct($saver);
    }
}
