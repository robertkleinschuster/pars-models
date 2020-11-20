<?php

namespace Pars\Model\File\Directory;

use Niceshops\Bean\Factory\AbstractBeanFactory;

/**
 * Class FileDirectoryBeanFactory
 * @package Pars\Model\File\Directory
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
