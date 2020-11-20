<?php

namespace Pars\Model\Authorization\RolePermission;


use Niceshops\Bean\Type\Base\AbstractBaseBean;

/**
 * Class RolePermissionBean
 * @package Pars\Model\Authorization\RolePermission
 */
class RolePermissionBean extends AbstractBaseBean
{
    public ?int $UserRole_ID = null;
    public ?string $UserPermission_Code = null;
    public ?bool $UserPermission_Active = null;
}
