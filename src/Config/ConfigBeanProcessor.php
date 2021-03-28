<?php

namespace Pars\Model\Config;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Processor\TimestampMetaFieldHandler;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class ConfigBeanProcessor
 * @package Pars\Model\Config
 */
class ConfigBeanProcessor extends AbstractBeanProcessor
{
    public bool $force = false;

    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('Config_Code', 'Config_Code', 'Config', 'Config_Code', true);
        $saver->addColumn('Config_Value', 'Config_Value', 'Config', 'Config_Code');
        $saver->addColumn('Config_Locked', 'Config_Locked', 'Config', 'Config_Code');
        $saver->addDefaultFields('Config');
        parent::__construct($saver);
        $this->addMetaFieldHandler(new TimestampMetaFieldHandler('Timestamp_Edit', 'Timestamp_Create'));
    }

    protected function validateForSave(BeanInterface $bean): bool
    {
        return parent::validateForSave($bean) && (!$bean->get('Config_Locked') || $this->force);
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return false;
    }


}
