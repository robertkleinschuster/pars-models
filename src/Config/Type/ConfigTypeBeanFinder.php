<?php

namespace Pars\Model\Config\Type;

use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class ConfigTypeBeanFinder
 * @package Pars\Model\Config\Type
 * @method ConfigTypeBean getBean(bool $fetchAllData = false)
 * @method ConfigTypeBeanList getBeanList(bool $fetchAllData = false)
 * @method ConfigTypeBeanFactory getBeanFactory()
 */
class ConfigTypeBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new ConfigTypeBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('ConfigType_Code')->setTable('ConfigType')->setKey(true);
        $loader->addField('ConfigType_Active')->setTable('ConfigType');
        $loader->addField('ConfigType_Code_Parent')->setTable('ConfigType');
    }
}
