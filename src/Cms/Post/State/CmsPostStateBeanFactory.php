<?php

namespace Pars\Model\Cms\Post\State;

use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class CmsPostStateBeanFactory
 * @package Pars\Model\Cms\Post\State
 */
class CmsPostStateBeanFactory extends AbstractBeanFactory
{

    protected function getBeanClass(array $data): string
    {
        return CmsPostStateBean::class;
    }

    protected function getBeanListClass(): string
    {
        return CmsPostStateBeanList::class;
    }
}
