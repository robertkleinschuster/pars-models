<?php

namespace Pars\Model\Authorization\UserRole;

use Niceshops\Bean\Type\Base\AbstractBaseBean;
use Niceshops\Bean\Type\Base\BeanListInterface;

/**
 * Class UserRoleBean
 * @package Pars\Model\Authorization\UserRole
 */
class UserRoleBean extends AbstractBaseBean
{
    public ?int $Person_ID = null;
    public ?int $UserRole_ID = null;
    public ?string $UserRole_Code = null;
    public ?bool $UserRole_Active = null;
    public ?BeanListInterface $UserPermission_BeanList = null;
}
