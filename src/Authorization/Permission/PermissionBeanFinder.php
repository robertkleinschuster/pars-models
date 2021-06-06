<?php

namespace Pars\Model\Authorization\Permission;


use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class PermissionBeanFinder
 * @package Pars\Model\Authorization\Permission
 * @method PermissionBean getBean(bool $fetchAllData = false)
 * @method PermissionBeanList getBeanList(bool $fetchAllData = false)
 */
class PermissionBeanFinder extends AbstractDatabaseBeanFinder
{

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('UserPermission_Code', 'UserPermission_Code', 'UserPermission', 'UserPermission_Code', true);
        $loader->addColumn('UserPermission_Active', 'UserPermission_Active', 'UserPermission', 'UserPermission_Code');
    }


    /**
     * @param string $userPermission_code
     * @return $this
     */
    public function setUserPermission_Code(string $userPermission_code): self
    {
        $this->getBeanLoader()->filterValue('UserPermission_Code', $userPermission_code);
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
