<?php

namespace Pars\Model\Authorization\RolePermission;

use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class RolePermissionBeanProcessor
 * @package Pars\Model\Authorization\RolePermission
 */
class RolePermissionBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('UserPermission_Code', 'UserPermission_Code', 'UserRole_UserPermission', 'UserPermission_Code', true);
        $saver->addColumn('UserRole_ID', 'UserRole_ID', 'UserRole_UserPermission', 'UserRole_ID', true);
    }

    protected function initValidator()
    {
    }
}
