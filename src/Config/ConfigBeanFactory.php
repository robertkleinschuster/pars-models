<?php


namespace Pars\Model\Config;


use Niceshops\Bean\Factory\AbstractBeanFactory;

class ConfigBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return ConfigBean::class;
    }

    protected function getBeanListClass(): string
    {
        return ConfigBeanList::class;
    }

}
