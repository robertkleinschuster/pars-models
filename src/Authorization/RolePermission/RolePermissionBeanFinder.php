<?php

namespace Pars\Model\Authorization\RolePermission;

use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class RolePermissionBeanFinder
 * @package Pars\Model\Authorization\RolePermission
 * @method RolePermissionBean getBean(bool $fetchAllData = false)
 * @method RolePermissionBeanList getBeanList(bool $fetchAllData = false)
 */
class RolePermissionBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
       return new RolePermissionBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('UserPermission_Code', 'UserPermission_Code', 'UserRole_UserPermission', 'UserPermission_Code', true);
        $loader->addColumn('UserRole_ID', 'UserRole_ID', 'UserRole_UserPermission', 'UserPermission_Code', true);
        $loader->addColumn('UserRole_Name', 'UserRole_Name', 'UserRole', 'UserRole_ID');
        $loader->addColumn('UserPermission_Active', 'UserPermission_Active', 'UserPermission', 'UserPermission_Code');
    }


    /**
     * @param string $userPermission_code
     * @return $this
     */
    public function setUserPersmission_Code(string $userPermission_code): self
    {
        $this->getBeanLoader()->filterValue('UserPermission_Code', $userPermission_code);
        return $this;
    }

    /**
     * @param int $userRole_id
     * @return $this
     */
    public function setUserRole_ID(int $userRole_id): self
    {
        $this->getBeanLoader()->filterValue('UserRole_ID', $userRole_id);
        return $this;
    }


    /**
     * @param bool $userPermission_active
     * @return $this
     */
    public function setUserPermission_Active(bool $userPermission_active): self
    {
        $this->getBeanLoader()->filterValue('UserPermission_Active', $userPermission_active);
        return $this;
    }
}
