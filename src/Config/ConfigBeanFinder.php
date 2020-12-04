<?php


namespace Pars\Model\Config;


use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

class ConfigBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('Config_Code', 'Config_Code', 'Config', 'Config_Code', true);
        $loader->addColumn('Config_Value', 'Config_Value', 'Config', 'Config_Code');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'Config', 'Config_Code');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Config', 'Config_Code');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'Config', 'Config_Code');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Config', 'Config_Code');
        parent::__construct($loader, new ConfigBeanFactory());
        $this->getBeanLoader()->order(['Config_Code' => self::ORDER_MODE_ASC]);

    }

    /**
     * @param string $config
     * @return $this
     */
    public function setConfig_Code(string $config)
    {
        $this->getBeanLoader()->filterValue('Config_Code', $config);
        return $this;
    }

}
