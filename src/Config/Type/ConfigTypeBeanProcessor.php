<?php

namespace Pars\Model\Config\Type;


use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class ConfigTypeBeanProcessor
 * @package Pars\Model\Config\Type
 */
class ConfigTypeBeanProcessor extends AbstractDatabaseBeanProcessor
{


    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addField('ConfigType_Code')->setTable('ConfigType')->setKey(true);
        $saver->addField('ConfigType_Active')->setTable('ConfigType');
        $saver->addField('ConfigType_Code_Parent')->setTable('ConfigType');
    }

    protected function initValidator()
    {
    }


}
