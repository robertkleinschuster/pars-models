<?php


namespace Pars\Model\Form\Field\Type;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

class FormFieldTypeBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new FormFieldTypeBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('FormFieldType.FormFieldType_Code')->setKey(true);
        $loader->addField('FormFieldType.FormFieldType_Active');
        $loader->addField('FormFieldType.FormFieldType_Order');
        $loader->addDefaultFields('FormFieldType');
        $loader->addOrder('FormFieldType_Order');
    }

}
