<?php

namespace Pars\Model\Authorization\UserRole;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Authorization\RolePermission\RolePermissionBeanFinder;

/**
 * Class UserRoleBeanFinder
 * @package Pars\Model\Authorization\UserRole
 * @method UserRoleBean getBean(bool $fetchAllData = false)
 * @method UserRoleBeanList getBeanList(bool $fetchAllData = false)
 */
class UserRoleBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('UserRole_ID', 'UserRole_ID', 'User_UserRole', 'UserRole_ID', true);
        $loader->addColumn('Person_ID', 'Person_ID', 'User_UserRole', 'UserRole_ID', true);
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'User_UserRole', 'UserRole_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'User_UserRole', 'UserRole_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'User_UserRole', 'UserRole_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'User_UserRole', 'UserRole_ID');
        $loader->addColumn('UserRole_Code', 'UserRole_Code', 'UserRole', 'UserRole_ID');
        $loader->addColumn('UserRole_Name', 'UserRole_Name', 'UserRole', 'UserRole_ID');
        $loader->addColumn('UserRole_Active', 'UserRole_Active', 'UserRole', 'UserRole_ID');
        $factory = new UserRoleBeanFactory();
        parent::__construct($loader, $factory);
        $rolePermissionFinder = new RolePermissionBeanFinder($adapter);
        $rolePermissionFinder->setUserPermission_Active(true);
        $this->addLinkedFinder($rolePermissionFinder, 'UserPermission_BeanList', 'UserRole_ID', 'UserRole_ID');
    }

    /**
     * @param int $person_id
     * @return $this
     */
    public function setPerson_ID(int $person_id): self
    {
        $this->getBeanLoader()->filterValue('Person_ID', $person_id);
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
     * @param string $userRole_code
     * @return $this
     */
    public function setUserRole_Code(string $userRole_code): self
    {
        $this->getBeanLoader()->filterValue('UserRole_Code', $userRole_code);
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
