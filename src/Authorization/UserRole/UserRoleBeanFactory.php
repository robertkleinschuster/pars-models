<?php

namespace Pars\Model\Authorization\UserRole;

use Niceshops\Bean\Factory\AbstractBeanFactory;

/**
 * Class UserRoleBeanFactory
 * @package Pars\Model\Authorization\UserRole
 */
class UserRoleBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return UserRoleBean::class;
    }

    protected function getBeanListClass(): string
    {
        return UserRoleBeanList::class;
    }
}
