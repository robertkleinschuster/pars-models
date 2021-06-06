<?php

namespace Pars\Model\Authorization\UserRole;

use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;


/**
 * Class UserRoleBeanProcessor
 * @package Pars\Model\Authorization\UserRole
 */
class UserRoleBeanProcessor extends AbstractDatabaseBeanProcessor
{

    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('UserRole_ID', 'UserRole_ID', 'User_UserRole', 'UserRole_ID', true);
        $saver->addColumn('Person_ID', 'Person_ID', 'User_UserRole', 'Person_ID', true);
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'User_UserRole', 'UserRole_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'User_UserRole', 'UserRole_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'User_UserRole', 'UserRole_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'User_UserRole', 'UserRole_ID');
    }

    protected function initValidator()
    {

    }

}
