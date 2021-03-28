<?php

namespace Pars\Model\Config\Type;

use Niceshops\Bean\Factory\AbstractBeanFactory;

/**
 * Class ConfigTypeBeanFactory
 * @package Pars\Model\Config\Type
 */
class ConfigTypeBeanFactory extends AbstractBeanFactory
{
    /**
     * @param array $data
     * @return string
     */
    protected function getBeanClass(array $data): string
    {
        return ConfigTypeBean::class;
    }

    /**
     * @return string
     */
    protected function getBeanListClass(): string
    {
        return ConfigTypeBeanList::class;
    }

}
