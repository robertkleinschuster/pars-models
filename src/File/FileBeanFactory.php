<?php

namespace Pars\Model\File;

use Niceshops\Bean\Factory\AbstractBeanFactory;

/**
 * Class FileBeanFactory
 * @package Pars\Model\File
 */
class FileBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return FileBean::class;
    }

    protected function getBeanListClass(): string
    {
        return FileBeanList::class;
    }
}
