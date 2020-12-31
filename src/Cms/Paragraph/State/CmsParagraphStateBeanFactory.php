<?php

namespace Pars\Model\Cms\Paragraph\State;


use Niceshops\Bean\Factory\AbstractBeanFactory;

/**
 * Class CmsParagraphStateBeanFactory
 * @package Pars\Model\Cms\Paragraph\State
 */
class CmsParagraphStateBeanFactory extends AbstractBeanFactory
{
    /**
     * @param array $data
     * @return string
     */
    protected function getBeanClass(array $data): string
    {
        return CmsParagraphStateBean::class;
    }

    /**
     * @return string
     */
    protected function getBeanListClass(): string
    {
        return CmsParagraphStateBeanList::class;
    }
}
