<?php

namespace Pars\Model\Cms\Page\Layout;

use Niceshops\Bean\Factory\AbstractBeanFactory;


class CmsPageLayoutBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return CmsPageLayoutBean::class;
    }

    protected function getBeanListClass(): string
    {
        return CmsPageLayoutBeanList::class;
    }
}
