<?php


namespace Pars\Model\Form;


use Pars\Bean\Factory\AbstractBeanFactory;

class FormBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return FormBean::class;
    }

    protected function getBeanListClass(): string
    {
        return FormBeanList::class;
    }

}
