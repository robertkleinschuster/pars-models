<?php

namespace Pars\Model\Authorization\RolePermission;

use Niceshops\Bean\Factory\AbstractBeanFactory;

/**
 * Class RolePermissionBeanFactory
 * @package Pars\Model\Authorization\RolePermission
 */
class RolePermissionBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return RolePermissionBean::class;
    }

    protected function getBeanListClass(): string
    {
        return RolePermissionBeanList::class;
    }
}
