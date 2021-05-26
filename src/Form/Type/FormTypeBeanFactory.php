<?php


namespace Pars\Model\Form\Type;


use Pars\Bean\Factory\AbstractBeanFactory;


class FormTypeBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return FormTypeBean::class;
    }

    protected function getBeanListClass(): string
    {
        return FormTypeBeanList::class;
    }

}
