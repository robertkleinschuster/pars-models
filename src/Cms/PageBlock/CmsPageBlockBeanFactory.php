<?php

namespace Pars\Model\Cms\PageBlock;

use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class CmsPageBlockBeanFactory
 * @package Pars\Model\Cms\PageBlock
 */
class CmsPageBlockBeanFactory extends AbstractBeanFactory
{

    protected function getBeanClass(array $data): string
    {
        return CmsPageBlockBean::class;
    }

    protected function getBeanListClass(): string
    {
        return CmsPageBlockBeanList::class;
    }

}
