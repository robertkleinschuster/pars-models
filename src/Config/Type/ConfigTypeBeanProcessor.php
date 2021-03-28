<?php

namespace Pars\Model\Config\Type;

use Laminas\Db\Adapter\AdapterInterface;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class ConfigTypeBeanProcessor
 * @package Pars\Model\Config\Type
 */
class ConfigTypeBeanProcessor extends AbstractBeanProcessor
{
    /**
     * ConfigTypeBeanProcessor constructor.
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addField('ConfigType_Code')->setTable('ConfigType')->setKey(true);
        $saver->addField('ConfigType_Active')->setTable('ConfigType');
        $saver->addField('ConfigType_Code_Parent')->setTable('ConfigType');
        parent::__construct($saver);
    }


}
