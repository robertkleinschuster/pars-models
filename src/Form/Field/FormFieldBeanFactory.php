<?php


namespace Pars\Model\Form\Field;


use Pars\Bean\Factory\AbstractBeanFactory;

class FormFieldBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return FormFieldBean::class;
    }

    protected function getBeanListClass(): string
    {
        return FormFieldBeanList::class;
    }

}
