<?php

namespace Pars\Model\Cms\Menu;


use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class CmsMenuBeanFactory
 * @package Pars\Model\Cms\Menu
 */
class CmsMenuBeanFactory extends AbstractBeanFactory
{


    protected function getBeanClass(array $data): string
    {
        return CmsMenuBean::class;
    }

    protected function getBeanListClass(): string
    {
        return CmsMenuBeanList::class;
    }


}
