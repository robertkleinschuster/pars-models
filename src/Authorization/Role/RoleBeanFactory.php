<?php

namespace Pars\Model\Authorization\Role;

use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class RoleBeanFactory
 * @package Pars\Model\Authorization\Role
 */
class RoleBeanFactory extends AbstractBeanFactory
{

    protected function getBeanClass(array $data): string
    {
        return RoleBean::class;
    }

    protected function getBeanListClass(): string
    {
        return RoleBeanList::class;
    }
}
