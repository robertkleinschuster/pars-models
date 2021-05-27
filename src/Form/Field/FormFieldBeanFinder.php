<?php


namespace Pars\Model\Form\Field;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class FormFieldBeanFinder
 * @package Pars\Model\Form\Field
 * @method FormFieldBeanFactory getBeanFactory()
 */
class FormFieldBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new FormFieldBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('FormField.FormField_ID')->setKey(true);
        $loader->addField('FormField.Form_ID');
        $loader->addField('FormField.FormFieldType_Code');
        $loader->addField('FormField.FormField_Required');
        $loader->addField('FormField.FormField_Order');
        $loader->addField('FormField.FormField_Code');
        $loader->addDefaultFields('FormField');
        $loader->addOrder('FormField_Order');
    }

}
