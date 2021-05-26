<?php


namespace Pars\Model\Form\Data;


use Pars\Bean\Factory\AbstractBeanFactory;

class FormDataBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return FormDataBean::class;
    }

    protected function getBeanListClass(): string
    {
        return FormDataBeanList::class;
    }

}
