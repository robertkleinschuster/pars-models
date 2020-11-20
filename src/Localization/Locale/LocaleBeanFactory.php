<?php

namespace Pars\Model\Localization\Locale;

use Niceshops\Bean\Factory\AbstractBeanFactory;

/**
 * Class LocaleBeanFactory
 * @package Pars\Model\Localization\Locale
 */
class LocaleBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return LocaleBean::class;
    }

    protected function getBeanListClass(): string
    {
        return LocaleBeanList::class;
    }
}
