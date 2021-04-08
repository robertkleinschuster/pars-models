<?php

namespace Pars\Model\Cms\Page;

use Pars\Bean\Factory\AbstractBeanFactory;

/**
 * Class CmsPageBeanFactory
 * @package Pars\Model\Cms\Page
 */
class CmsPageBeanFactory extends AbstractBeanFactory
{

    protected function getBeanClass(array $data): string
    {
        return CmsPageBean::class;
    }

    protected function getBeanListClass(): string
    {
        return CmsPageBeanList::class;
    }
}
