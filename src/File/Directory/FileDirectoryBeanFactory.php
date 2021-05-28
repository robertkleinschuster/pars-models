<?php

namespace Pars\Model\File\Directory;

use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class FileDirectoryBeanFactory
 * @package Pars\Model\File\Directory
 * @method FileDirectoryBean getEmptyBean(array $data)
 * @method FileDirectoryBeanList getEmptyBeanList()
 */
class FileDirectoryBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return FileDirectoryBean::class;
    }

    protected function getBeanListClass(): string
    {
        return FileDirectoryBeanList::class;
    }
}
