<?php

namespace Pars\Model\Cms\Block\State;


use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class CmsBlockStateBeanFactory
 * @package Pars\Model\Cms\Block\State
 */
class CmsBlockStateBeanFactory extends AbstractBeanFactory
{
    /**
     * @param array $data
     * @return string
     */
    protected function getBeanClass(array $data): string
    {
        return CmsBlockStateBean::class;
    }

    /**
     * @return string
     */
    protected function getBeanListClass(): string
    {
        return CmsBlockStateBeanList::class;
    }
}
