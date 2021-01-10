<?php

namespace Pars\Model\Article\Data;

use Niceshops\Bean\Factory\AbstractBeanFactory;

/**
 * Class ArticleDataBeanFactory
 * @package Pars\Model\Article\Data
 */
class ArticleDataBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return ArticleDataBean::class;
    }

    protected function getBeanListClass(): string
    {
        return ArticleDataBeanList::class;
    }
}
