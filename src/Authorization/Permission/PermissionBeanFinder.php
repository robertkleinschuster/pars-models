<?php

namespace Pars\Model\Authorization\Permission;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

class PermissionBeanFinder extends AbstractBeanFinder
{

    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('UserPermission_Code', 'UserPermission_Code', 'UserPermission', 'UserPermission_Code', true);
        $loader->addColumn('UserPermission_Active', 'UserPermission_Active', 'UserPermission', 'UserPermission_Code');
        parent::__construct($loader, new PermissionBeanFactory());
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
