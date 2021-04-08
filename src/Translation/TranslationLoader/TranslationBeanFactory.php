<?php

namespace Pars\Model\Translation\TranslationLoader;

use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class TranslationBeanFactory
 * @package Pars\Model\Translation\TranslationLoader
 * @method TranslationBean getEmptyBean(array $data)
 * @method TranslationBeanList getEmptyBeanList()(array $data)
 */
class TranslationBeanFactory extends AbstractBeanFactory
{

    protected function getBeanClass(array $data): string
    {
        return TranslationBean::class;
    }

    protected function getBeanListClass(): string
    {
        return TranslationBeanList::class;
    }
}
