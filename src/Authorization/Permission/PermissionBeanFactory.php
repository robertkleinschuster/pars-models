<?php

namespace Pars\Model\Authorization\Permission;

use Pars\Bean\Factory\AbstractBeanFactory;

class PermissionBeanFactory extends AbstractBeanFactory
{


    protected function getBeanClass(array $data): string
    {
        return PermissionBean::class;
    }

    protected function getBeanListClass(): string
    {
        return PermissionBeanList::class;
    }
}
