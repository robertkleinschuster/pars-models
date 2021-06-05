<?php

namespace Pars\Model\Config;

use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Config\ConfigProcessorInterface;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class ConfigBeanProcessor
 * @package Pars\Model\Config
 */
class ConfigBeanProcessor extends AbstractDatabaseBeanProcessor implements ConfigProcessorInterface
{
    public const OPTION_SAVE_LOCKED = 'save_locked';

    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('Config_Code', 'Config_Code', 'Config', 'Config_Code', true);
        $saver->addColumn('Config_Value', 'Config_Value', 'Config', 'Config_Code');
        $saver->addColumn('Config_Locked', 'Config_Locked', 'Config', 'Config_Code');
        $saver->addDefaultFields('Config');

    }

    protected function initValidator()
    {

    }


    protected function validateForSave(BeanInterface $bean): bool
    {
        return parent::validateForSave($bean) && (!$bean->get('Config_Locked') || $this->hasOption(self::OPTION_SAVE_LOCKED));
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return false;
    }

    public function saveValue(string $key, string $value, string $type)
    {
        $finder = new ConfigBeanFinder($this->getParsContainer());
        $finder->setConfig_Code($key);
        $finder->setConfigType_Code($type);
        $list = $finder->getBeanFactory()->getEmptyBeanList();
        if ($finder->count() == 1) {
            $bean = $finder->getBean();
            $bean->Config_Code = $key;
            $bean->Config_Value = $value;
        } else {
            $bean = $finder->getBeanFactory()->getEmptyBean([]);
            $bean->Config_Code = $key;
            $bean->Config_Value = $value;
            $bean->ConfigType_Code = $type;
            $bean->Config_Locked = false;
        }
        $this->addOption(self::OPTION_SAVE_LOCKED);
        $list->push($bean);
        $this->setBeanList($list);
        return $this->save();
    }


}
