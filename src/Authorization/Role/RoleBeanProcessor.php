<?php

namespace Pars\Model\Authorization\Role;

use Cocur\Slugify\Slugify;
use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use Pars\Bean\Processor\AbstractBeanProcessor;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\String\StringHelper;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;

/**
 * Class RoleBeanProcessor
 * @package Pars\Model\Authorization\Role
 */
class RoleBeanProcessor extends AbstractBeanProcessor implements
    ValidationHelperAwareInterface,
    TranslatorAwareInterface
{
    use ValidationHelperAwareTrait;
    use TranslatorAwareTrait;

    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('UserRole_ID', 'UserRole_ID', 'UserRole', 'UserRole_ID', true);
        $saver->addColumn('UserRole_Code', 'UserRole_Code', 'UserRole', 'UserRole_ID');
        $saver->addColumn('UserRole_Name', 'UserRole_Name', 'UserRole', 'UserRole_ID');
        $saver->addColumn('UserRole_Active', 'UserRole_Active', 'UserRole', 'UserRole_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'UserRole', 'UserRole_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'UserRole', 'UserRole_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'UserRole', 'UserRole_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'UserRole', 'UserRole_ID');

        parent::__construct($saver);
    }

    protected function beforeSave(BeanInterface $bean)
    {
        if (!$bean->empty('UserRole_Code')) {
            $bean->set('UserRole_Code', StringHelper::slugify($bean->get('UserRole_Code')));
        }
        parent::beforeSave($bean);
    }


    /**
     * @param string $code
     * @return string
     */
    protected function translate(string $code)
    {
        if ($this->hasTranslator()) {
            return $this->getTranslator()->translate($code, 'validation');
        }
        return $code;
    }

    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('UserRole_Code')) {
            $this->getValidationHelper()->addError('UserRole_Code', $this->translate('userrole.code.empty'));
        } else {
            $finder = new RoleBeanFinder($this->adapter);
            $finder->setUserRole_Code($bean->get('UserRole_Code'));
            if (!$bean->empty('UserRole_ID')) {
                $finder->setUserRole_ID($bean->get('UserRole_ID'), true);
            }
            if ($finder->count() !== 0) {
                $this->getValidationHelper()->addError('UserRole_Code', $this->translate('userrole.code.unique'));
            }
        }
        if ($bean->empty('UserRole_Name')) {
            $this->getValidationHelper()->addError('UserRole_Name', $this->translate('userrole.name.empty'));
        }
        return !$this->getValidationHelper()->hasError();
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return true;
    }
}
