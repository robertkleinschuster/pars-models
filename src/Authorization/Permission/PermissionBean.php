<?php

namespace Pars\Model\Authorization\Permission;

use Niceshops\Bean\Type\Base\AbstractBaseBean;

class PermissionBean extends AbstractBaseBean
{
    public ?string $UserPermission_Code = null;
    public ?bool $UserPermission_Active = null;
}
