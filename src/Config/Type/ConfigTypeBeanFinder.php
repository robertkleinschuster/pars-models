<?php

namespace Pars\Model\Config\Type;

use Laminas\Db\Adapter\AdapterInterface;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class ConfigTypeBeanFinder
 * @package Pars\Model\Config\Type
 * @method ConfigTypeBean getBean(bool $fetchAllData = false)
 * @method ConfigTypeBeanList getBeanList(bool $fetchAllData = false)
 * @method ConfigTypeBeanFactory getBeanFactory()
 */
class ConfigTypeBeanFinder extends AbstractBeanFinder
{
    /**
     * ConfigTypeBeanFinder constructor.
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addField('ConfigType_Code')->setTable('ConfigType')->setKey(true);
        $loader->addField('ConfigType_Active')->setTable('ConfigType');
        $loader->addField('ConfigType_Code_Parent')->setTable('ConfigType');
        parent::__construct($loader, new ConfigTypeBeanFactory());
    }

}
