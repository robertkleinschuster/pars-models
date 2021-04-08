<?php

namespace Pars\Model\Config;

use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class ConfigBeanFactory
 * @package Pars\Model\Config
 * @method ConfigBean getEmptyBean(array $data)
 * @method ConfigBeanList getEmptyBeanList()
 */
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
