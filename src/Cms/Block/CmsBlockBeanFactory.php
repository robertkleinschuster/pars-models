<?php

namespace Pars\Model\Cms\Block;

use Niceshops\Bean\Factory\AbstractBeanFactory;


/**
 * Class CmsBlockBeanFactory
 * @package Pars\Model\Cms\Block
 */
class CmsBlockBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return CmsBlockBean::class;
    }

    protected function getBeanListClass(): string
    {
        return CmsBlockBeanList::class;
    }
}
