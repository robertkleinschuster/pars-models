<?php

namespace Pars\Model\Config;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Config\ConfigFinderInterface;
use Pars\Core\Container\ParsContainer;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Core\Database\ParsDatabaseAdapter;
use Pars\Model\Config\Type\ConfigTypeBeanFinder;

/**
 * Class ConfigBeanFinder
 * @package Pars\Model\Config
 * @method ConfigBean getBean(bool $fetchAllData = false)
 * @method ConfigBeanList getBeanList(bool $fetchAllData = false)
 * @method ConfigBeanFactory getBeanFactory()
 */
class ConfigBeanFinder extends AbstractDatabaseBeanFinder implements ConfigFinderInterface
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new ConfigBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('Config_Code', 'Config_Code', 'Config', 'Config_Code', true);
        $loader->addColumn('Config_Value', 'Config_Value', 'Config', 'Config_Code');
        $loader->addColumn('Config_Description', 'Config_Description', 'Config', 'Config_Code');
        $loader->addColumn('Config_Options', 'Config_Options', 'Config', 'Config_Code');
        $loader->addColumn('Config_Locked', 'Config_Locked', 'Config', 'Config_Code');
        $loader->addField('ConfigType_Code')->setTable('Config')->setKey(true);
        $loader->addField('ConfigType_Code_Parent')->setTable('ConfigType')->setJoinField('ConfigType_Code');
        $loader->addDefaultFields('Config');
    }


    /**
     * @param string|string[] $config
     * @return $this
     */
    public function setConfig_Code($config): self
    {
        $this->getBeanLoader()->filterValue('Config_Code', $config);
        return $this;
    }

    /**
     * @param string $type
     * @param bool $exclude
     * @return $this
     */
    public function setConfigType_Code(string $type, bool $exclude = false): self
    {
        if ($exclude) {
            $this->exclude(['ConfigType_Code' => $type]);
        } else {
            $this->filter(['ConfigType_Code' => $type]);
        }
        return $this;
    }

    /**
     * @return ConfigBeanList
     */
    public function getConfigBeanList()
    {
        try {
            return $this->getBeanList();
        } catch (\Throwable $exception) {
            return $this->getBeanFactory()->getEmptyBeanList();
        }
    }

    /**
     * @return Type\ConfigTypeBeanList
     */
    public function getConfigTypeBeanList()
    {
        $finder = new ConfigTypeBeanFinder($this->getParsContainer());
        try {
            return $finder->getBeanList();
        } catch (\Throwable $exception) {
            return $finder->getBeanFactory()->getEmptyBeanList();
        }
    }


}
