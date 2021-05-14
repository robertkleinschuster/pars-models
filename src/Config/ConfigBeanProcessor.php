<?php

namespace Pars\Model\Config;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Processor\AbstractBeanProcessor;
use Pars\Bean\Processor\TimestampMetaFieldHandler;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Config\ConfigProcessorInterface;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class ConfigBeanProcessor
 * @package Pars\Model\Config
 */
class ConfigBeanProcessor extends AbstractBeanProcessor implements ConfigProcessorInterface
{
    public const OPTION_SAVE_LOCKED = 'save_locked';

    protected $finder;

    public function __construct(Adapter $adapter)
    {
        $this->finder = new ConfigBeanFinder($adapter);
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
        return parent::validateForSave($bean) && (!$bean->get('Config_Locked') || $this->hasOption(self::OPTION_SAVE_LOCKED));
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return false;
    }

    public function saveValue(string $key, string $value, string $type)
    {
        $this->finder->setConfig_Code($key);
        $this->finder->setConfigType_Code($type);
        $list = $this->finder->getBeanFactory()->getEmptyBeanList();
        if ($this->finder->count() == 1) {
            $bean = $this->finder->getBean();
            $bean->Config_Code = $key;
            $bean->Config_Value = $value;
        } else {
            $bean = $this->finder->getBeanFactory()->getEmptyBean([]);
            $bean->Config_Code = $key;
            $bean->Config_Value = $value;
            $bean->ConfigType_Code = $type;
            $bean->Config_Locked = false;
        }
        $this->addOption(self::OPTION_SAVE_LOCKED);
        $list->push($bean);
        $this->setBeanList($list);
        $result = $this->save();
        return $result;
    }


}
