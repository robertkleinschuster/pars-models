<?php

namespace Pars\Model\File\Type;

use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class FileTypeBeanFactory
 * @package Pars\Model\File\Type
 */
class FileTypeBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return FileTypeBean::class;
    }

    protected function getBeanListClass(): string
    {
        return FileTypeBeanList::class;
    }
}
