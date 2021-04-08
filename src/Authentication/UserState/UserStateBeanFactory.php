<?php

namespace Pars\Model\Authentication\UserState;

use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class UserBeanFactory
 * @package Pars\Model\Authentication\User
 */
class UserStateBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return UserStateBean::class;
    }

    protected function getBeanListClass(): string
    {
        return UserStateBeanList::class;
    }
}
