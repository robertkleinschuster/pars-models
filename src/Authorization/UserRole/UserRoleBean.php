<?php

namespace Pars\Model\Authorization\UserRole;

use Niceshops\Bean\Type\Base\AbstractBaseBean;
use Niceshops\Bean\Type\Base\BeanListInterface;
use Pars\Model\Authorization\Role\RoleBean;

/**
 * Class UserRoleBean
 * @package Pars\Model\Authorization\UserRole
 */
class UserRoleBean extends RoleBean
{
    public ?int $Person_ID = null;
}
