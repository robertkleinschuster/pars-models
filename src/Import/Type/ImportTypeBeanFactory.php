<?php


namespace Pars\Model\Import\Type;


use Niceshops\Bean\Factory\AbstractBeanFactory;

class ImportTypeBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return ImportTypeBean::class;
    }

    protected function getBeanListClass(): string
    {
        return ImportTypeBeanList::class;
    }

}
