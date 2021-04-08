<?php


namespace Pars\Model\Authentication\ApiKey;


use Pars\Bean\Factory\AbstractBeanFactory;

class ApiKeyBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return ApiKeyBean::class;
    }

    protected function getBeanListClass(): string
    {
        return ApiKeyBeanList::class;
    }

}
