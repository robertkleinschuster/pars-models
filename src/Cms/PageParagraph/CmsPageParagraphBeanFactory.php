<?php

namespace Pars\Model\Cms\PageParagraph;

use Niceshops\Bean\Factory\AbstractBeanFactory;

/**
 * Class CmsPageParagraphBeanFactory
 * @package Pars\Model\Cms\PageParagraph
 */
class CmsPageParagraphBeanFactory extends AbstractBeanFactory
{

    protected function getBeanClass(array $data): string
    {
        return CmsPageParagraphBean::class;
    }

    protected function getBeanListClass(): string
    {
        return CmsPageParagraphBeanList::class;
    }

}
