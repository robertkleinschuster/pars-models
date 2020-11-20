<?php

namespace Pars\Model\Cms\Paragraph\Type;

use Niceshops\Bean\Factory\AbstractBeanFactory;

class CmsParagraphTypeBeanFactory extends AbstractBeanFactory
{

    protected function getBeanClass(array $data): string
    {
        return CmsParagraphTypeBean::class;
    }

    protected function getBeanListClass(): string
    {
        return CmsParagraphTypeBeanList::class;
    }
}
