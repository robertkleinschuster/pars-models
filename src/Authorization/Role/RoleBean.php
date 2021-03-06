<?php

namespace Pars\Model\Authorization\Role;

use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Bean\Type\Base\BeanListInterface;

/**
 * Class RoleBean
 * @package Pars\Model\Authorization\Role
 */
class RoleBean extends AbstractBaseBean
{
    public ?int $UserRole_ID = null;
    public ?string $UserRole_Code = null;
    public ?string $UserRole_Name = null;
    public ?bool $UserRole_Active = null;
    public ?BeanListInterface $UserPermission_BeanList = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;

}
