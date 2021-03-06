<?php

namespace Pars\Model\Authorization\Role;

use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Authorization\RolePermission\RolePermissionBeanFinder;

/**
 * Class RoleBeanFinder
 * @package Pars\Model\Authorization\Role
 * @method RoleBean getBean(bool $fetchAllData = false)
 * @method RoleBeanList getBeanList(bool $fetchAllData = false)
 */
class RoleBeanFinder extends AbstractDatabaseBeanFinder
{

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('UserRole_ID', 'UserRole_ID', 'UserRole', 'UserRole_ID', true);
        $loader->addColumn('UserRole_Code', 'UserRole_Code', 'UserRole', 'UserRole_ID');
        $loader->addColumn('UserRole_Name', 'UserRole_Name', 'UserRole', 'UserRole_ID');
        $loader->addColumn('UserRole_Active', 'UserRole_Active', 'UserRole', 'UserRole_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'UserRole', 'UserRole_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'UserRole', 'UserRole_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'UserRole', 'UserRole_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'UserRole', 'UserRole_ID');
    }

    protected function initLinkedFinder()
    {
        $rolePermissionFinder = new RolePermissionBeanFinder($this->getDatabaseAdapter());
        $rolePermissionFinder->setUserPermission_Active(true);
        $this->addLinkedFinder($rolePermissionFinder, 'UserPermission_BeanList', 'UserRole_ID', 'UserRole_ID');
    }


    /**
     * @param int $userRole_id
     * @param bool $exclude
     * @return $this
     */
    public function setUserRole_ID(int $userRole_id, bool $exclude = false): self
    {
        if ($exclude) {
            $this->getBeanLoader()->excludeValue('UserRole_ID', $userRole_id);
        } else {
            $this->getBeanLoader()->filterValue('UserRole_ID', $userRole_id);
        }
        return $this;
    }

    /**
     * @param string $userRole_code
     * @param bool $exclude
     * @return $this
     */
    public function setUserRole_Code(string $userRole_code, bool $exclude = false): self
    {
        if ($exclude) {
            $this->getBeanLoader()->excludeValue('UserRole_Code', $userRole_code);
        } else {
            $this->getBeanLoader()->filterValue('UserRole_Code', $userRole_code);
        }
        return $this;
    }


    /**
     * @param bool $userRole_active
     * @return $this
     */
    public function setUserRole_Active(bool $userRole_active): self
    {
        $this->getBeanLoader()->filterValue('UserRole_Active', $userRole_active);
        return $this;
    }
}
