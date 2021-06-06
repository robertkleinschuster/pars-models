<?php

namespace Pars\Model\Authorization\Role;

use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\String\StringHelper;


/**
 * Class RoleBeanProcessor
 * @package Pars\Model\Authorization\Role
 */
class RoleBeanProcessor extends AbstractDatabaseBeanProcessor
{

    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('UserRole_ID', 'UserRole_ID', 'UserRole', 'UserRole_ID', true);
        $saver->addColumn('UserRole_Code', 'UserRole_Code', 'UserRole', 'UserRole_ID');
        $saver->addColumn('UserRole_Name', 'UserRole_Name', 'UserRole', 'UserRole_ID');
        $saver->addColumn('UserRole_Active', 'UserRole_Active', 'UserRole', 'UserRole_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'UserRole', 'UserRole_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'UserRole', 'UserRole_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'UserRole', 'UserRole_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'UserRole', 'UserRole_ID');
    }

    protected function initValidator()
    {
    }


    protected function beforeSave(BeanInterface $bean)
    {
        if (!$bean->empty('UserRole_Code')) {
            $bean->set('UserRole_Code', StringHelper::slugify($bean->get('UserRole_Code')));
        }
        parent::beforeSave($bean);
    }

    public function translate(string $code, array $vars = [], ?string $namespace = null): string
    {
        return $this->translateValidation($code, $vars);
    }


    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('UserRole_Code')) {
            $this->getValidationHelper()->addError('UserRole_Code', $this->translate('userrole.code.empty'));
        } else {
            $finder = new RoleBeanFinder($this->getDatabaseAdapter());
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

}
