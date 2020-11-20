<?php

namespace Pars\Model\Article\Translation;

use Niceshops\Bean\Factory\AbstractBeanFactory;

/**
 * Class ArticleTranslationBeanFactory
 * @package Pars\Model\Article\Translation
 */
class ArticleTranslationBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return ArticleTranslationBean::class;
    }

    protected function getBeanListClass(): string
    {
        return ArticleTranslationBeanList::class;
    }
}
