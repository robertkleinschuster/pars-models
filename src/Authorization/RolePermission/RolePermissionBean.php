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
    public ?string $UserRole_Name = null;
    public ?bool $UserPermission_Active = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;
}
