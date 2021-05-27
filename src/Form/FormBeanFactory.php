<?php


namespace Pars\Model\Form;


use Pars\Bean\Factory\AbstractBeanFactory;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Bean\Type\Base\BeanListInterface;

/**
 * Class FormBeanFactory
 * @package Pars\Model\Form
 * @method FormBean getEmptyBean(array $data)
 * @method FormBeanList getEmptyBeanList()
 */
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
