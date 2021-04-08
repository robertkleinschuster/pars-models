<?php

namespace Pars\Model\Cms\Menu\Type;

use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class CmsMenuTypeBeanFactory
 * @package Pars\Model\Cms\Menu\Type
 */
class CmsMenuTypeBeanFactory extends AbstractBeanFactory
{

    protected function getBeanClass(array $data): string
    {
        return CmsMenuTypeBean::class;
    }

    protected function getBeanListClass(): string
    {
        return CmsMenuTypeBeanList::class;
    }
}
