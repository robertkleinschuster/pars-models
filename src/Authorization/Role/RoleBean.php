<?php

namespace Pars\Model\Authorization\Role;

use Niceshops\Bean\Type\Base\AbstractBaseBean;
use Pars\Model\Authorization\Permission\PermissionBeanList;

/**
 * Class RoleBean
 * @package Pars\Model\Authorization\Role
 */
class RoleBean extends AbstractBaseBean
{
    public ?int $UserRole_ID = null;
    public ?string $UserRole_Code = null;
    public ?bool $UserRole_Active = null;
    public ?PermissionBeanList $UserPermission_BeanList = null;

}
