<?php

namespace Pars\Model\Cms\Block\Type;

use Niceshops\Bean\Factory\AbstractBeanFactory;

class CmsBlockTypeBeanFactory extends AbstractBeanFactory
{

    protected function getBeanClass(array $data): string
    {
        return CmsBlockTypeBean::class;
    }

    protected function getBeanListClass(): string
    {
        return CmsBlockTypeBeanList::class;
    }
}
