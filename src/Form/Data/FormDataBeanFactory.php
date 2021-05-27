<?php


namespace Pars\Model\Form\Data;


use Pars\Bean\Factory\AbstractBeanFactory;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Bean\Type\Base\BeanListInterface;

/**
 * Class FormDataBeanFactory
 * @package Pars\Model\Form\Data
 * @method FormDataBean getEmptyBean(array $data)
 * @method FormDataBeanList getEmptyBeanList()
 */
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
