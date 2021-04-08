<?php

namespace Pars\Model\Cms\Post;

use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class CmsPostBeanFactory
 * @package Pars\Model\Cms\Post
 */
class CmsPostBeanFactory extends AbstractBeanFactory
{
    function getBeanClass(array $data): string
    {
        return CmsPostBean::class;
    }

    protected function getBeanListClass(): string
    {
        return CmsPostBeanList::class;
    }


}
