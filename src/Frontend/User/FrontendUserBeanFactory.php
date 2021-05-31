<?php


namespace Pars\Model\Frontend\User;


use Pars\Bean\Factory\AbstractBeanFactory;

class FrontendUserBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return FrontendUserBean::class;
    }

    protected function getBeanListClass(): string
    {
        return FrontendUserBeanList::class;
    }

}
