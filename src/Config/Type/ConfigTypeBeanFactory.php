<?php

namespace Pars\Model\Config\Type;

use Pars\Bean\Factory\AbstractBeanFactory;
use Pars\Model\Config\ConfigBean;

/**
 * Class ConfigTypeBeanFactory
 * @package Pars\Model\Config\Type
 * @method ConfigTypeBeanList getEmptyBeanList()
 * @method ConfigBean getEmptyBean(array $data)
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
