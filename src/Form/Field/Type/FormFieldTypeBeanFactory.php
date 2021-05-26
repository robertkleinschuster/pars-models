<?php


namespace Pars\Model\Form\Field\Type;


use Pars\Bean\Factory\AbstractBeanFactory;
use Pars\Model\Form\Field\FormFieldBean;
use Pars\Model\Form\Field\FormFieldBeanList;

class FormFieldTypeBeanFactory extends AbstractBeanFactory
{
    protected function getBeanClass(array $data): string
    {
        return FormFieldTypeBean::class;
    }

    protected function getBeanListClass(): string
    {
        return FormFieldTypeBeanList::class;
    }

}
