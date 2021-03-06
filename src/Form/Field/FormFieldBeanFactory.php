<?php


namespace Pars\Model\Form\Field;


use Pars\Bean\Factory\AbstractBeanFactory;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Bean\Type\Base\BeanListInterface;

/**
 * Class FormFieldBeanFactory
 * @package Pars\Model\Form\Field
 * @method FormFieldBean getEmptyBean(array $data)
 * @method FormFieldBeanList getEmptyBeanList()
 */
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
